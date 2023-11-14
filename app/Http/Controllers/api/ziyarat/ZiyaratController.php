<?php

namespace App\Http\Controllers\api\ziyarat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\ZiyaratEnquiry;
use App\Models\Admin;
use App\Models\User;
use App\Notifications\AdminNotification;


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
            'date' => 'required|date',
            'user_id'   => ['required', 'alpha_dash', Rule::notIn('undefined')],

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
                'user_id'   => $request->user_id,
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
                $user = User::where('id', '=', $request->user_id)->first();
                    $admin = Admin::where('role', 'super_admin')->first(); 
                    if ($admin && $user) {
                        $name = $user->fname . ' ' . $user->lname;
                        $message = [
                            'title' => trans('msg.notification.ziyarat_enquiry_title'),
                            'message' => trans('msg.notification.ziyarat_enquiry_message', ['name' => $name]),
                            'name' => $name,
                            'email' => $request->email,
                            'profile' => $user->photo ? $user->photo : '',
                        ];

                        $admin->notify(new AdminNotification($message));
                    }
                return response()->json([
                    'status'    => 'success',
                    'message'   =>  trans('msg.enquiry.success'),
                  
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
