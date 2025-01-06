<?php

namespace App\Http\Controllers\RestAPI\v1\auth;

use App\Http\Controllers\Controller;
use App\Models\PhoneOrEmailVerification;
use App\Models\User;
use App\Utils\Helpers;
use App\Utils\SMS_module;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Gateways\Traits\SmsGateway;

class PhoneVerificationController extends Controller
{
    public function check_phone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'temporary_token' => 'required',
            'phone' => 'required|min:11|max:14'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = User::where(['temporary_token' => $request->temporary_token])->first();

        if (isset($user) == false) {
            return response()->json([
                'message' => translate('temporary_token_mismatch'),
            ], 200);
        }

        $token = rand(1000, 9999);
        DB::table('phone_or_email_verifications')->insert([
            'phone_or_email' => $request['phone'],
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $published_status = 0;
        $payment_published_status = config('get_payment_publish_status');
        if (isset($payment_published_status[0]['is_published'])) {
            $published_status = $payment_published_status[0]['is_published'];
        }

        if($published_status == 1){
            $response = SmsGateway::send($request['phone'], $token);
        }else{
            $response = SMS_module::send($request['phone'], $token);
        }

        $otp_resend_time = Helpers::get_business_settings('otp_resend_time') > 0 ? Helpers::get_business_settings('otp_resend_time') : 0;
        return response()->json([
            'message' => $response,
            'token' => 'active',
            'resend_time' => $otp_resend_time
        ], 200);
    }

    public function resend_otp_check_phone(Request $request){
        $validator = Validator::make($request->all(), [
            'temporary_token' => 'required',
            'phone' => 'required|min:11|max:14'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $otp_resend_time = Helpers::get_business_settings('otp_resend_time') > 0 ? Helpers::get_business_settings('otp_resend_time') : 0;
        $user = User::where(['temporary_token' => $request->temporary_token])->first();
        $token = PhoneOrEmailVerification::where('phone_or_email',$request['phone'])->first();
        $temp_block_time = Helpers::get_business_settings('temporary_block_time') ?? 5; //minute

        // Time Difference in Minutes
        $time_differance = 0;
        if($token){
            $token_time = Carbon::parse($token->created_at);
            $add_time = $token_time->addSeconds($otp_resend_time);
            $time_differance = $add_time > Carbon::now() ? Carbon::now()->diffInSeconds($add_time) : 0;
        }

        if($time_differance==0){
            $new_token = rand(1000, 9999);
            if($token){
                $token->token = $new_token;
                $token->otp_hit_count = 0;
                $token->is_temp_blocked = 0;
                $token->temp_block_time = null;
                $token->created_at = now();
                $token->save();
            }else{
                $token_data = new PhoneOrEmailVerification();
                $token_data->phone_or_email = $user->phone;
                $token_data->token = $new_token;
                $token_data->created_at = now();
                $token_data->updated_at = now();
                $token_data->save();
            }

            $published_status = 0;
            $payment_published_status = config('get_payment_publish_status');
            if (isset($payment_published_status[0]['is_published'])) {
                $published_status = $payment_published_status[0]['is_published'];
            }

            if($published_status == 1){
                $response = SmsGateway::send($request['phone'], $new_token);
            }else{
                $response = SMS_module::send($request['phone'], $new_token);
            }

            return response()->json([
                'message' => $response,
                'token' => 'active',
                'resend_time'=> $otp_resend_time,
            ], 200);
        } else {
            return response()->json(['errors' => [
                ['message' => translate('please_try_again_after').' '.CarbonInterval::seconds($time_differance)->cascade()->forHumans()]
            ]], 403);
        }

    }

    public function verify_phone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'temporary_token' => 'required',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $max_otp_hit = Helpers::get_business_settings('maximum_otp_hit') ?? 5;
        $temp_block_time = Helpers::get_business_settings('temporary_block_time') ?? 5; //minute
        $verify = PhoneOrEmailVerification::where(['phone_or_email' => $request['phone'], 'token' => $request['otp']])->first();

        if (isset($verify)) {
            $user = User::where(['temporary_token' => $request['temporary_token']])->first();

            if(isset($verify->temp_block_time ) && Carbon::parse($verify->temp_block_time)->diffInSeconds() <= $temp_block_time){
                $time = $temp_block_time - Carbon::parse($verify->temp_block_time)->diffInSeconds();


                return response()->json(['errors' => [
                    ['message' => translate('please_try_again_after').' '.CarbonInterval::seconds($time)->cascade()->forHumans()]
                ]], 403);
            }

            $user->phone = $request['phone'];
            $user->is_phone_verified = 1;
            $user->save();
            $verify->delete();

            $token = $user->createToken('LaravelAuthApp')->accessToken;
            return response()->json([
                'message' => translate('otp_verified'),
                'token' => $token
            ], 200);
        }else{
            $verification = PhoneOrEmailVerification::where(['phone_or_email' => $request['phone']])->first();

            if($verification){
                if(isset($verification->temp_block_time) && Carbon::parse($verification->temp_block_time)->diffInSeconds() <= $temp_block_time){
                    $time= $temp_block_time - Carbon::parse($verification->temp_block_time)->diffInSeconds();

                    $message = translate('please_try_again_after').' '.CarbonInterval::seconds($time)->cascade()->forHumans();

                }elseif($verification->is_temp_blocked == 1 && isset($verification->created_at) && Carbon::parse($verification->created_at)->diffInSeconds() >= $temp_block_time){
                    $verification->otp_hit_count = 1;
                    $verification->is_temp_blocked = 0;
                    $verification->temp_block_time = null;
                    $verification->updated_at = now();
                    $verification->save();

                    $message = translate('otp_not_found');

                }elseif($verification->otp_hit_count >= $max_otp_hit && $verification->is_temp_blocked == 0){
                    $verification->is_temp_blocked = 1;
                    $verification->temp_block_time = now();
                    $verification->updated_at = now();
                    $verification->save();

                    $time= $temp_block_time - Carbon::parse($verification->temp_block_time)->diffInSeconds();
                    $message = translate('too_many_attempts'). translate('please_try_again_after').' '.CarbonInterval::seconds($time)->cascade()->forHumans();

                }else{
                    $verification->otp_hit_count += 1;
                    $verification->save();

                    $message = translate('otp_not_found');
                }
            }else{
                $message = translate('otp_not_found');
            }
        }

        return response()->json(['errors' => [
            ['message' => $message]
        ]], 403);
    }

    public function send_otp(Request $request){
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $user = User::where(['phone' => $request['phone']])->first();
        if(!empty($user)){
            $user->phone = $request['phone'];
            $user->save();
            $result =  $this->resend_otp($request['phone']);
            if($result==true){
                return response()->json([
                    'status' => true,
                    'message' => translate('otp_sent'),
                    'profile_status' => false
                ], 200);
            } else {
                return response()->json(['errors' => [
                    ['message' => translate('otp_not_sent')]
                ]], 403);
            }

        } else {
            $user = new User();
            $user->phone = $request['phone'];
            if($user->save()){
                $result =  $this->resend_otp($request['phone']);
                if($result==true){
                    return response()->json([
                        'status' => true,
                        'message' => translate('otp_sent'),
                        'profile_status' => false
                    ], 200);
                } else {
                    return response()->json(['errors' => [
                        ['message' => translate('otp_not_sent')]
                    ]], 403);
                }
            }


        }
    }


    public function resend_otp($number){
        $otp = rand(100000, 999999);
        $client = new \GuzzleHttp\Client();
        $url = "https://connectexpress.in/api/v3/index.php";
        $params = [
            'method' => 'sms',
            'api_key' => '05c05017988bc8087a13f2c950e9f33fb1cfd38a',
            'to' => $number,
            'sender' => 'TNKRED',
            'message' => "Your navishkar account login OTP is $otp TNKRED",
            'format' => 'php'
        ];
        try {
            $client = new \GuzzleHttp\Client(['verify' => false]);
            $response = $client->request('GET', $url, ['query' => $params]);
            $responseBody = json_decode($response->getBody(), true);
            $user = User::where(['phone' => $number])->first();
            $user->phone_otp = $otp;
            $user->save();
            if ($responseBody['status'] == 'success') {
               return true;
            } else {
                return false;
            }

        } catch (\Exception $e) {
            return response()->json(['errors' => [
                ['message' => translate('otp_not_sent')]
            ]], 403);
        }
    }

    public function verify_otp(Request $request){
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
            'phone' => 'required',
            'cm_firebase_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $user = User::where(['phone' => $request['phone'],'phone_otp'=>$request->otp])->first();
        if (isset($user)) {
            $user->cm_firebase_token = $request->cm_firebase_token;
            $user->save();
            $token = $user->createToken('LaravelAuthApp')->accessToken;
            if(!empty($user->f_name) && !empty($user->l_name) && !empty($user->email)){
                return response()->json([
                    'status' => true,
                    'message' => translate('otp_verified'),
                    'token' => $token,
                    'profile_status' => true
                ], 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => translate('otp_verified'),
                    'token' => $token,
                    'profile_status' => false
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => translate('otp_notverified'),
                'token' => ""
            ], 200);
        }
    }


}
