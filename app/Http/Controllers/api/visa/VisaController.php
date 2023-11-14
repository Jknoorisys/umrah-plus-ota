<?php

namespace App\Http\Controllers\api\visa;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\VisaCountry;
use App\Models\VisaPackage;
use App\Models\VisaTypes;
use App\Notifications\AdminNotification;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VisaController extends Controller
{
    public function getVisaType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id'   => ['required', 'alpha_dash', Rule::notIn('undefined')],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'errors'    =>  $validator->errors(),
                'message'   =>  trans('msg.validation'),
            ], 400);
        }

        try {
            $country = VisaCountry::where('id', $request->country_id)->first();

            if (!empty($country)) {
                $visaType = VisaTypes::where('country_id', $country->id)
                    ->join('visa_countries', 'visa_types.country_id', '=', 'visa_countries.id')
                    ->select('visa_types.*', 'visa_countries.country')
                    ->get();

                if (!empty($visaType)) {
                    return response()->json([
                        'status'    => 'success',
                        'message'   =>  trans('msg.list.success'),
                        'data'      => $visaType,
                    ], 200);
                } else {
                    return response()->json([
                        'status'    => 'failed',
                        'message'   => trans('msg.list.failed'),
                        'data'      => []
                    ], 400);
                }
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.no_content'),
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

    public function sendEnquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'visatype_id'   => ['required', 'alpha_dash', Rule::notIn('undefined')],
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'travellers' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'errors'    =>  $validator->errors(),
                'message'   =>  trans('msg.validation'),
            ], 400);
        }

        try {
            $visaType = VisaTypes::where('id', $request->visatype_id)->orWhere('status','=','active')->first();
            if (!empty($visaType)) {
                $visaPrice = $visaType->fees * $request->travellers;
                $data = [
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'travellers' => $request->travellers,
                    'visa_type_id' => $request->visatype_id,
                    'price' => $visaPrice,
                ];
                
                $visa = VisaPackage::create($data);
                

                $price = $data['price'];

                if ($visa == true) {
                    $adminUser = Admin::where('role', 'super_admin')->first(); // Replace 'admin' with your actual admin role
                    if ($adminUser) {
                        $message = [
                            'title' => trans('msg.notification.visaPackage'),
                            'message' => trans('msg.notification.enquiry'),
                            'name' => $request->email,
                            'email' => $price,
                            'profile' => $visaType,
                        ];
                        $usermessage = [
                            'title' => trans('msg.notification.visaPackage'),
                            'message' => trans('msg.notification.userenquiry'),
                        ];
                        $adminUser->notify(new AdminNotification($message));
                        $request->email->notify(new UserNotification($usermessage));
                    }
                    
                    return response()->json([
                        'status'    => 'success',
                        'message'   =>  trans('msg.list.success'),
                        'data'      => $visaType,
                    ], 200);
                } else {
                    return response()->json([
                        'status'    => 'failed',
                        'message'   => trans('msg.list.failed'),
                        'data'      => []
                    ], 400);
                }
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.no_content'),
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
