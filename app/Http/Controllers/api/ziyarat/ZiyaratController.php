<?php

namespace App\Http\Controllers\api\ziyarat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\ZiyaratEnquiry;

class ZiyaratController extends Controller
{
    public function sendEnquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ziyarat_package'   => 'required',
            'email' => 'required|email',
            'name' => 'required|string',
            'mobile' => 'required|numeric',
            'travellers' => 'required|numeric',
            'price' => 'required|numeric',
            'country' => 'required|string',
            'date' => 'required|date'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'errors'    =>  $validator->errors(),
                'message'   =>  trans('msg.validation'),
            ], 400);
        }

        try {

            $price = $request->price * $request->travellers;
            $data = [
                'ziyarat_package' => $request->ziyarat_package,
                'email' => $request->email,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'travellers' => $request->travellers,
                'price' => $price,
                'country' => $request->country,
                'date' => $request->date
            ];

            $enquiry = ZiyaratEnquiry::create($data);
            if($enquiry)
            {
                return response()->json([
                    'status'    => 'success',
                    'message'   =>  trans('msg.enquiry.success'),
                    'data'      => $enquiry,
                ], 200);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.enquiry.failed'),
                    'data'      => []
                ], 400);
            }    
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'failed',
                'message' =>  trans('msg.error'),
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
