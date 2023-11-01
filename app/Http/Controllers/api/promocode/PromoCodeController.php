<?php

namespace App\Http\Controllers\api\promocode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromoCodes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PromoCodeController extends Controller
{
    public function GetPromoCode(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'category' => 'required',Rule::in(['activity','transfer','flight','hotel','umrah','ziyarat','visa']),
                'page_number' => 'required|numeric'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }
            
            $per_page = 10;
            $page_number = $request->input(key:'page_number', default:1);

            $category = $request->category;
            $promocode = PromoCodes::where('service','=',$category);
            $total = $promocode->count();
            $data = $promocode->offset(($page_number - 1) * $per_page)
                                    ->limit($per_page)
                                    ->get();
            if(!empty($promocode))
            {
                return response()->json([
                    'status' => 'success',
                    'message' => trans('msg.list.success'),
                    'total'     => $total,
                    'data' => $data,
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

    public function ValidatePromoCode(Request $request)
    {

    }
}
