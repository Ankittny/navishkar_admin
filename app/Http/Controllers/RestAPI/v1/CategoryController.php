<?php

namespace App\Http\Controllers\RestAPI\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Utils\CategoryManager;
use App\Utils\Helpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\WorkShopCategory;
use App\Models\WorkShopProduct;

class CategoryController extends Controller
{
    public function get_categories(Request $request): JsonResponse
    {
        $categoriesID = [];
        if ($request->has('seller_id') && $request['seller_id'] != null) {
            // Finding category ids
            $categoriesID = Product::active()
                ->when($request->has('seller_id') && $request['seller_id'] != null && $request['seller_id'] != 0, function ($query) use ($request) {
                    return $query->where(['added_by' => 'seller'])
                        ->where('user_id', $request['seller_id']);
                })->when($request->has('seller_id') && $request['seller_id'] != null && $request['seller_id'] == 0, function ($query) use ($request) {
                    return $query->where(['added_by' => 'admin',
                    ]);
                })->pluck('category_id');
        }
        $categories = Category::when($request->has('seller_id') && $request['seller_id'] != null, function ($query) use ($categoriesID) {
                $query->where('organic_status',0)
                ->whereIn('id', $categoriesID);
            })

            ->with(['product' => function ($query) {
                return $query->active()->withCount(['orderDetails']);
            }])
            ->withCount(['product' => function ($query) use ($request) {
                $query->when($request->has('seller_id') && !empty($request['seller_id']), function ($query) use ($request) {
                    $query->where(['added_by' => 'seller', 'user_id' => $request['seller_id'], 'status' => '1','organic_status'=>0]);
                });
            }])->with(['childes' => function ($query) {
                $query->with(['childes' => function ($query) {
                    $query->withCount(['subSubCategoryProduct'])->where('position', 2);
            }])->withCount(['subCategoryProduct'])->where('position', 1)->where('organic_status',0);
            }, 'childes.childes'])
            ->where(['position' => 0,'organic_status'=>0])->get();

        $categories = CategoryManager::getPriorityWiseCategorySortQuery(query: $categories);
        return response()->json($categories->values());
    }

  	public function get_ingredients(Request $request): JsonResponse
    {
        $categoriesID = [];
        if ($request->has('seller_id') && $request['seller_id'] != null) {
            // Finding category ids
            $categoriesID = Product::active()
                ->when($request->has('seller_id') && $request['seller_id'] != null && $request['seller_id'] != 0, function ($query) use ($request) {
                    return $query->where(['added_by' => 'seller'])
                        ->where('user_id', $request['seller_id']);
                })->when($request->has('seller_id') && $request['seller_id'] != null && $request['seller_id'] == 0, function ($query) use ($request) {
                    return $query->where(['added_by' => 'admin',
                    ]);
                })->pluck('category_id');
        }
        $categories = Category::when($request->has('seller_id') && $request['seller_id'] != null, function ($query) use ($categoriesID) {
                $query->where('organic_status',1)
                ->whereIn('id', $categoriesID);
            })
            ->with(['product' => function ($query) {
                return $query->active()->withCount(['orderDetails']);
            }])
            ->withCount(['product' => function ($query) use ($request) {
                $query->when($request->has('seller_id') && !empty($request['seller_id']), function ($query) use ($request) {
                    $query->where(['added_by' => 'seller', 'user_id' => $request['seller_id'], 'status' => '1','organic_status'=>1]);
                });
            }])->with(['childes' => function ($query) {
                $query->with(['childes' => function ($query) {
                    $query->withCount(['subSubCategoryProduct'])->where('position', 2);
            }])->withCount(['subCategoryProduct'])->where('position', 1)->where('organic_status',1);
            }, 'childes.childes'])
            ->where(['position' => 0,'organic_status'=>1])->get();
        $categories = CategoryManager::getPriorityWiseCategorySortQuery(query: $categories);
        return response()->json($categories->values());
    }

    public function get_products(Request $request, $id): JsonResponse
    {
        return response()->json(Helpers::product_data_formatting(CategoryManager::products($id, $request), true), 200);
    }

    public function find_what_you_need()
    {
        $find_what_you_need_categories = Category::where('parent_id', 0)
            ->with(['childes' => function ($query) {
                $query->withCount(['subCategoryProduct' => function ($query) {
                    return $query->active();
                }]);
            }])
            ->withCount(['product' => function ($query) {
                return $query->active();
            }])
            ->get()->toArray();

        $get_categories = [];
        foreach($find_what_you_need_categories as $category){
            $slice = array_slice($category['childes'], 0, 4);
            $category['childes'] = $slice;
            $get_categories[] = $category;
        }

        $final_category = [];
        foreach ($get_categories as $category) {
            if (count($category['childes']) > 0) {
                $final_category[] = $category;
            }
        }

        return response()->json(['find_what_you_need'=>$final_category], 200);
    }

    public function workshopcategory() {
        try {
            $workshopcategories = WorkShopCategory::select(
                    'name',
                    'slug',
                    'type',
                    'short_description',
                    'cover_pic',
                    'operative',
                    'description',
                    'meta_title',
                    'keywords'
                )
                ->addSelect(\DB::raw("CONCAT('" . url('public/assets/back-end/work-shop/') .'/'. "', cover_pic) as cover_pic_path"))
                ->latest()
                ->get();

            if ($workshopcategories->isEmpty()) {
                return response()->json(['workshopcategories' => []], 200);
            }

            // Convert to array for response and ensure the proper alias for cover_pic_path
            $workshopcategories = $workshopcategories->map(function ($category) {
                $category->cover_pic_path = $category->cover_pic_path ?? null;  // Ensuring it is null if no cover_pic
                return $category;
            });

            return response()->json(['workshopcategories' => $workshopcategories], 200);
        } catch (\Exception $e) {
            return response()->json(['workshopcategories' => []], 200);
        }
    }


    public function workshopproducts($slug){
        try {
        $cat_id = WorkShopCategory::where('slug', $slug)->first();
            if(!empty($cat_id)){
                    $workshopProducts = WorkShopProduct::select(
                        'title',
                        'cat_id',
                        'image',
                        'slug',
                        'description',
                        'meta_description',
                        'meta_title',
                        'keywords'
                        )->addSelect(\DB::raw("CONCAT('" . url('public/assets/back-end/work-shop-product/') .'/'. "', image) as image_path"))
                        ->where('cat_id', $cat_id->id)->get();
                    if ($workshopProducts->isEmpty()) {
                        return response()->json(['status'=>false,'workshopproducts' => []], 200);
                    }
                return response()->json(['status'=>true,'workshopproducts' => $workshopProducts], 200);
            } else {
                return response()->json(['status'=>false,'workshopproducts' =>[]], 200);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch workshop products'], 500);
        }
    }

}
