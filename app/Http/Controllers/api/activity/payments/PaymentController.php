<?php

namespace App\Http\Controllers\api\activity\payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromoCodes;
use function App\Helpers\AuthUser;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    // public function ActivityPromoCode(Request $request)
    // {
    //     try{

    //         $promocode = PromoCodes::where('service','=','activity')->get();
    //         if(!empty($promocode))
    //         {
    //             return response()->json([
    //                 'status' => 'success',
    //                 'message' => trans('msg.list.success'),
    //                 'data' => $promocode,
    //             ], 200);
    //         } else {
                
    //             return response()->json([
    //                 'status' => 'failed',
    //                 'message' => trans('msg.list.failed'),
    //                 'data' => $promocode,
    //             ], 400); 
    //         }

    //     }catch (\Throwable $e) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => trans('msg.error'),
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // public function validatePromoCode(Request $request) 
    // {
    //     try{

    //         $validator = Validator::make($request->all(), [
    //             'code' => ['required'],
    //             'user_id' => ['required'],
                
    //                     ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => 'failed',
    //                 'errors' => $validator->errors(),
    //                 'message' => trans('msg.validation'),
    //             ], 400);
    //         }

    //         $promoCode = PromoCodes::where('code', $request->input('code'))->first();

    //     if (!$promoCode) {
    //         return response()->json(['message' => 'Invalid promo code'], 404);
    //     }

    //     if ($promoCode->isExpired()) {
    //         return response()->json(['message' => 'Promo code has expired'], 422);
    //     }

    //     $user = AuthUser($request->user_id); 

    //     if ($promoCode->hasUserReachedMaxUsage($user)) {
    //         return response()->json(['message' => 'User has reached the maximum usage for this promo code'], 422);
    //     }

    //     return response()->json(['message' => 'Promo code is valid']);
    //     }
    //     catch (\Throwable $e) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => trans('msg.error'),
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
        
    // }
}
