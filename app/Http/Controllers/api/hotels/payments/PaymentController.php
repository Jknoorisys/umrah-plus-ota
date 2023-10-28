<?php

namespace App\Http\Controllers\api\hotels\payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromoCodes;

class PaymentController extends Controller
{
    public function HotelPromoCode(Request $request)
    {
        try{

            $promocode = PromoCodes::where('service','=','hotel')->get();
            if(!empty($promocode))
            {
                return response()->json([
                    'status' => 'success',
                    'message' => trans('msg.list.success'),
                    'data' => $promocode,
                ], 200);
            } else {
                
                return response()->json([
                    'status' => 'failed',
                    'message' => trans('msg.list.failed'),
                    'data' => $promocode,
                ], 400); 
            }

        }catch (\Throwable $e) {
            return response()->json([
                'status' => 'failed',
                'message' => trans('msg.error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
