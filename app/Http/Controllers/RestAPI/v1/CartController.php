<?php

namespace App\Http\Controllers\RestAPI\v1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Utils\CartManager;
use App\Utils\Helpers;
use App\Models\CartShipping;
use App\Utils\OrderManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function React\Promise\all;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function __construct(
        private Order $order,
    )
    {
    }

    public function cart(Request $request)
    {
        $user = Helpers::get_customer($request);
        $cart_query = Cart::with('product','shop');
        if ($user == 'offline') {
            $cart = $cart_query->where(['customer_id' => $request->guest_id, 'is_guest' => 1])->get();
        } else {
            $cart = $cart_query->where(['customer_id' => $user->id, 'is_guest' => '0'])->get();
        }

        if ($cart) {
            foreach ($cart as $key => $value) {
                if (!isset($value['product'])) {
                    $cart_data = Cart::find($value['id']);
                    $cart_data->delete();

                    unset($cart[$key]);
                }
            }

            $cart->map(function ($data) use ($request) {
                $product = Product::active()->find($data->product_id);
                if ($product) {
                    $data['is_product_available'] = 1;
                } else {
                    $data['is_product_available'] = 0;
                }
                $data['choices'] = json_decode($data['choices']);
                $data['variations'] = json_decode($data['variations']);

                $data['minimum_order_amount_info'] = OrderManager::minimum_order_amount_verify($request, $data['cart_group_id'])['minimum_order_amount'];

                $cart_group = Cart::where(['product_type' => 'physical'])->where('cart_group_id', $data['cart_group_id'])->get()->groupBy('cart_group_id');
                if (isset($cart_group[$data['cart_group_id']])) {
                    $data['free_delivery_order_amount'] = OrderManager::free_delivery_order_amount($data['cart_group_id']);
                } else {
                    $data['free_delivery_order_amount'] = [
                        'status' => 0,
                        'amount' => 0,
                        'percentage' => 0,
                        'shipping_cost_saved' => 0,
                    ];
                }

                $data['product']['total_current_stock'] = isset($data['product']['current_stock']) ? $data['product']['current_stock'] : 0;
                if (isset($data['product']['variation']) && !empty($data['product']['variation'])) {
                    $variants = json_decode($data['product']['variation']);
                    foreach ($variants as $var) {
                        if ($data['variant'] == $var->type) {
                            $data['product']['total_current_stock'] = $var->qty;
                        }
                    }
                }
                unset($data['product']['variation']);
                return $data;
            });
        }

        return response()->json($cart, 200);
    }

    public function addToCart(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'quantity' => 'required',
        ], [
            'id.required' => translate('Product ID is required!')
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }
        $cart = CartManager::add_to_cart($request);
        return response()->json($cart, 200);
    }

    public function update_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required',
            'quantity' => 'required',
        ], [
            'key.required' => translate('Cart key or ID is required!')
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $response = CartManager::update_cart_qty($request);
        return response()->json($response);
    }

    public function remove_from_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required'
        ], [
            'key.required' => translate('Cart key or ID is required!')
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $user = Helpers::get_customer($request);
        Cart::where([
            'id' => $request->key,
            'customer_id' => ($user == 'offline' ? (session('guest_id') ?? $request->guest_id) : $user->id),
            'is_guest' => ($user == 'offline' ? 1 : '0'),
        ])->delete();
        return response()->json(translate('successfully_removed'));
    }

    public function remove_all_from_cart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required'
        ], [
            'key.required' => translate('Cart key or ID is required!')
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $user = Helpers::get_customer($request);
        Cart::where([
            'customer_id' => ($user == 'offline' ? $request->guest_id : $user->id),
            'is_guest' => ($user == 'offline' ? 1 : '0'),
        ])->delete();
        return response()->json(translate('successfully_removed'));
    }

    public function updateCheckedCartItems(Request $request): JsonResponse
    {
        if ($request['action'] == 'unchecked') {
            Cart::whereIn('id', $request['ids'])->update(['is_checked' => 0]);
        } elseif ($request['action'] == 'checked') {
            Cart::whereIn('id', $request['ids'])->update(['is_checked' => 1]);
        }
        return response()->json(translate('Successfully_Update'), 200);
    }
    public function add_shipping_cost(Request $request){
        $validator = Validator::make($request->all(), [
            'zipcode' => 'required'
        ], [
            'zipcode.required' => translate('Zipcode required!')
        ]);
        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }
        $checkZon = $this->getPinCodeDetails($request);
        if(!empty($checkZon['delivery_codes'])){
            $result = $this->delivery_cost($request->zipcode,$request);
            if($result){
                return response()->json(['status'=>true,'message'=>'Cost Add successfully'], 200);
            } else {
                return response()->json(['status'=>false,'message'=>'Cost not add'], 200);
            }
        } else {
            return response()->json(['error' => 'Pincode not found'], 200);
        }
    }

    public function getPinCodeDetails(Request $request)
     {
        $client = new Client();
        $url = "https://track.delhivery.com/c/api/pin-codes/json/?filter_codes=" . $request->zipcode;
        try {
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => '298946431eb6b00835b0cf6aaaad8c9a4242c111',
                ],
                'verify' => false,
            ]);
            $data = json_decode($response->getBody(), true);
            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delivery_cost($delivery_pincode,$request)
    {
        $user = Helpers::get_customer($request);
        //dd($user);
        $cartData = Cart::where('customer_id', $user->id)->get();
        //dd($cartData);
        if ($cartData->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 404);
        }
        $totalShippingCost = 0;
        $groupid = CartManager::get_cart_group_ids($request);

        if (empty($groupid)) {
            return response()->json(['error' => 'Cart group ID not found'], 404);
        }
        foreach ($cartData as $itemsData) {
            $product = Product::find($itemsData->product_id);
            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }
            $client = new Client();
            $md = "S";
            $ss = "RTO";
            $d_pin = $delivery_pincode;
            $o_pin = $product->seller->shop->pin_code;
            $cgm = 50;
            $url = "https://track.delhivery.com/api/kinko/v1/invoice/charges/.json"; // Fixed URL
            try {
                $response = $client->request('GET', $url, [
                    'headers' => [
                        'Authorization' => 'Token 298946431eb6b00835b0cf6aaaad8c9a4242c111',
                    ],
                    'query' => [
                        'md' => $md,
                        'ss' => $ss,
                        'd_pin' => $d_pin,
                        'o_pin' => $o_pin,
                        'cgm' => $cgm,
                    ],
                    'verify' => false,
                ]);
                $data = json_decode($response->getBody(), true);
                if ($data && isset($data[0]['total_amount']) && $data[0]['total_amount'] != 0) {
                 Cart::where(['product_id' => $itemsData->product_id, 'customer_id' => $user->id])->update(['delivery_cost' => currencyConverter(amount: $data[0]['total_amount']*$itemsData->quantity)]);
                    $totalShippingCost += currencyConverter(amount: $data[0]['total_amount']*$itemsData->quantity);
                } else {
                    \Log::warning('No valid shipping cost found for pincode ' . $d_pin);
                }
            } catch (\Exception $e) {
                    \Log::error('API Request Error: ' . $e->getMessage());
                     return response()->json(['error' => 'Failed to fetch shipping cost'], 500);
            }
        }
        $shipping = CartShipping::firstOrNew(['cart_group_id' => $groupid[0]]);
        $shipping->shipping_method_id = 9;
        $shipping->shipping_cost = $totalShippingCost;
        $shipping->save();
        return response()->json(['success' => 'Shipping cost calculated successfully', 'total_cost' => $totalShippingCost]);
    }
}
