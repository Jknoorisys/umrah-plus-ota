<?php

namespace App\Http\Controllers\api\umrah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\UmrahEnquiry;
use App\Models\Admin;
use App\Models\User;
use App\Notifications\AdminNotification;

class UmrahController extends Controller
{
    public function list(Request $request) {
        $validator = Validator::make($request->all(), [
            'page_no'   => ['required','numeric', Rule::notIn('undefined')],
            'search'    => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors(),
            ], 400);
        } 

        try {
            $page = $request->input(key: 'page', default: 1);
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $search = $request->search;

            $query = DB::connection('umrahaddons')->table('tbl_full_package')->where('status', '=', '1');

            if (isset($search) && !empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('details', 'like', '%' . $search . '%')
                        ->orWhere('mecca_hotel', 'like', '%' . $search . '%')
                        ->orWhere('madinah_hotel', 'like', '%' . $search . '%');
                });
            }

            $total = $query->count();

            $packages = $query->orderByDesc('id')
                                ->offset($offset)
                                ->limit($limit)
                                ->get();

                if (!empty($packages)) {
                    return response()->json([
                        'status'    => 'success',
                        'message'   => trans('msg.list.success'),
                        'total'     => $total,
                        'data'      => $packages,
                    ], 200);
                } else {
                    return response()->json([
                        'status'    => 'failed',
                        'message'   => trans('msg.list.failed'),
                    ], 400);
                }

        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => trans('msg.error'),
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function view(Request $request) {
        $validator = Validator::make($request->all(), [
            'package_id'   => ['required','numeric', Rule::notIn('undefined')],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors(),
            ], 400);
        } 

        try {
           
            $package_id = $request->input('package_id');
            $package = DB::connection('umrahaddons')
                ->table('tbl_full_package')
                ->where('id', $package_id)
                ->where('status', '1')
                ->first();

                if (!empty($package)) {
                    $packageDates = DB::connection('umrahaddons')->table('tbl_full_package_dates')->where('full_package_id', $package_id)->get();
                    $packageImages = DB::connection('umrahaddons')->table('tbl_full_package_image')->where('full_package_id', $package_id)->get();

                    $package->dates = $packageDates;
                    $package->images = $packageImages;

                    return response()->json([
                        'status'    => 'success',
                        'message'   => trans('msg.list.success'),
                        'data'      => $package,
                    ], 200);
                } else {
                    return response()->json([
                        'status'    => 'failed',
                        'message'   => trans('msg.list.failed'),
                    ], 400);
                }

        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => trans('msg.error'),
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function sendEnquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'umrah_package'   => 'required',
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
                'umrah_package' => $request->umrah_package,
                'user_id'   => $request->user_id,
                'email' => $request->email,
                'name' => $request->name,
                'mobile' => $request->mobile,
                'travellers' => $request->travellers,
                'price' => $price,
                'country' => $request->country,
                'date' => $request->date
            ];

            $enquiry = UmrahEnquiry::create($data);
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
