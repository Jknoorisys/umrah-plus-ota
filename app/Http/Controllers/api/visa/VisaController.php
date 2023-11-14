<?php

namespace App\Http\Controllers\api\visa;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Embassy;
use App\Models\VisaCountry;
use App\Models\VisaEnquiry;
use App\Models\VisaPackage;
use App\Models\VisaPackages;
use App\Models\VisaTypes;
use App\Notifications\AdminNotification;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VisaController extends Controller
{
    public function getVisaPackages(Request $request) {
        try {
            $packages = VisaPackages::where('status', '=', 'active')->get();

            if (!empty($packages)) {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'data'      => $packages,
                ], 200);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
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

    public function getVisaPackage(Request $request) {
        $validator = Validator::make($request->all(), [
            'package_id'   => ['required', 'alpha_dash', Rule::notIn('undefined')],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'errors'    =>  $validator->errors(),
                'message'   =>  trans('msg.validation'),
            ], 400);
        }

        try {
            $package = VisaPackages::where([['id', '=', $request->package_id], ['status', '=', 'active']])
                                    ->with(['visaTypes' => function ($query) {
                                        $query->where('status', 'active');
                                    }])
                                    ->first();

            if (!empty($package)) {
                $embassyIds = explode(',', $package->embassy);
                $embassies = Embassy::whereIn('id', $embassyIds)->where('status', 'active')->get();
                $package->embassy = $embassies;

                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'data'      => $package,
                ], 200);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
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

    public function sendEnquiry(Request $request) {
        $validator = Validator::make($request->all(), [
            'visa_type_id'   => ['required', 'alpha_dash', Rule::notIn('undefined')],
            'name' => 'required',
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
            $visaType = VisaTypes::where('id', $request->visa_type_id)->orWhere('status','=','active')->first();
            if (!empty($visaType)) {
                $visaPrice = $visaType->fees * $request->travellers;
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'travellers' => $request->travellers,
                    'visa_type_id' => $request->visa_type_id,
                    'price' => $visaPrice,
                ];
                
                $visa = VisaEnquiry::create($data);

                if ($visa) {
                    $admin = Admin::where('role', 'super_admin')->first(); // Replace 'admin' with your actual admin role
                    if ($admin) {
                        $message = [
                            'title' => trans('msg.notification.visa_enquiry_title'),
                            'message' => trans('msg.notification.visa_enquiry_message', ['name' => $request->name]),
                            'name' => $request->name,
                            'email' => $request->email,
                            'profile' => '',
                        ];

                        $admin->notify(new AdminNotification($message));
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
