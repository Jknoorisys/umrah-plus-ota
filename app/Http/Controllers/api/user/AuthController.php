<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Libraries\Services;
use App\Models\Admin;
use App\Notifications\AdminNotification;
use App\Notifications\RegistrationEmail;
use App\Notifications\ResetPasswordEmail;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $messages = [
            'fname.required' => 'First name is required.',
            'fname.max' => 'First name must not exceed :max characters.',
            'lname.required' => 'Last name is required.',
            'lname.max' => 'Last name must not exceed :max characters.',
            'country_code.required' => 'Country code is required.',
        ];

        $validator = Validator::make($req->all(), [
            'fname'     => ['required', 'string', 'max:255'],
            'lname'     => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', Rule::unique('users')],
            'country_code' => ['required'],
            'phone'     => ['required', 'numeric', Rule::unique('users')],
            'password'  => ['required', 'string', 'min:8'],
        ], $messages);

        $errors = [];
        foreach ($validator->errors()->messages() as $key => $value) {
            $key = 'error_message';
            $errors[$key] = is_array($value) ? implode(',', $value) : $value;
        }

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'message'   => $errors['error_message'] ? $errors['error_message'] : trans('msg.validation'),
                'errors'    => $validator->errors()
            ], 400);
        }

        try {
            $user = User::where('email', $req->input('email'))->get();

            if (!empty($user)) {
                $otp = rand(100000, 999999);

                $data = [
                    'fname' => $req->fname, 
                    'lname' => $req->lname,
                    'password' => Hash::make($req->password),
                    'email' => $req->email, 
                    'country_code' => $req->country_code,
                    'phone' => $req->phone, 
                    'otp' => $otp, 
                ];

                $insert = User::create($data);

                if ($insert) {

                    $name = $req->fname.' '.$req->lname;
                    $insert->notify(New RegistrationEmail($name, $req->email, $otp));

                    return response()->json([
                        'status'    => 'success',
                        'message'   => __('msg.registration.otp-sent'),
                    ], 200);
                } else {
                    return response()->json([
                        'status'    => 'failed',
                        'message'   => __('msg.registration.otp-failed'),
                    ], 400);
                }
            }
            else
            {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => __('msg.registration.email-exist'),
                ], 400);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => __('msg.error'),
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function verifyOTP(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email'   => ['required','email'],
            'otp'     => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'errors'    =>  $validator->errors(),
                'message'   => trans('msg.validation'),
            ], 400);
        }

        try {
            $otp = $req->otp;
            $email = $req->email;

            $user = User::where('email', '=', $email)->first();

            if(!empty($user))
            {
                if ($user->otp == $otp) {
                    $name = $user->fname.' '.$user->lname;
                    $user->is_verified = 'yes';
                    $update = $user->save();

                    if ($update) {
                        $message = [
                            'title' => trans('msg.notification.user_registered_title'),
                            'message' => trans('msg.notification.user_registered_message', ['name' => $name]),
                            'name' => $name,
                            'email' => $user->email,
                            'profile' => $user->photo,
                        ];
        
                        $admin = Admin::where('role', '=', 'super_admin')->first();
                        $admin->notify(new AdminNotification($message));
    
                        return response()->json([
                            'status'    => 'success',
                            'message'   => __('msg.registration.success'),
                        ], 200);
                    } else {
                        return response()->json([
                            'status'    => 'failed',
                            'message'   =>   trans('msg.registration.failed'),
                        ], 400);
                    }
                    
                } else {
                    return response()->json([
                        'status'    => 'failed',
                        'message'   =>   trans('msg.registration.otp-invalid'),
                    ], 400);
                }
            }else{
                return response()->json([
                    'status'    => 'failed',
                    'message'   =>   trans('msg.registration.not-found'),
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

    public function resendRegOTP(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email'   => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                    'status'    => 'failed',
                    'errors'    =>  $validator->errors(),
                    'message'   =>  trans('msg.validation'),
            ], 400);
        }

        try {
            $email = $req->email;
            $user = User::where('email', '=', $email)->first();

            if (!empty($user)) {
                if ($user->is_verified == 'no') {

                    $otp = rand(100000, 999999);
                    $user->otp = $otp;
                    $update = $user->save();  

                    if ($update) {
                        $name = $user->fname.' '.$user->lname;
                        $user->notify(New RegistrationEmail($name, $req->email, $otp));

                        return response()->json([
                            'status'    => 'success',
                            'message'   =>  trans('msg.registration.otp-sent'),
                        ], 200);
                    }
                } else {
                    return response()->json([
                        'status'    => 'failed',
                        'message'   =>   trans('msg.registration.email-verified'),
                    ], 400);
                }
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   =>  trans('msg.registration.not-found'),
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

    public function forgetpassword(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email'   => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'errors'    =>  $validator->errors(),
                'message'   =>  trans('msg.validation'),
            ], 400 );
        }

        try {
            $email = $req->email;
            $user = User::where('email', '=', $email)->first();

            if (!empty($user)) {
                $otp = rand(100000, 999999);

                $data = [
                    'email' => $user->email,
                    'token' => $otp,
                    'created_at' => Carbon::now()
                ];

                $insert = DB::table('password_reset_tokens')->insert($data);

                if ($insert) {

                    $name = $user->fname.' '.$user->lname;
                    $user->notify(new ResetPasswordEmail($name, $req->email, $otp));

                    return response()->json([
                            'status'    => 'success',
                            'data' => $user,
                            'message'   =>  trans('msg.reset-password.otp-sent'),
                        ], 200);
                } else {
                    return response()->json([
                            'status'    => 'failed',
                            'message'   =>  trans('msg.reset-password.otp-failed'),
                        ], 400 );
                }
            } else {
                return response()->json([
                        'status'    => 'failed',
                        'message'   =>  trans('msg.reset-password.not-found'),
                    ], 400 );
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'failed',
                'message' =>  trans('msg.error'),
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function forgotPasswordValidate(Request $req)
    {
        $validator = Validator::make($req->all(), [
            
            'otp'        => 'required|numeric',
            'password'   => 'required|max:20||min:8',
        ]);

        $errors = [];
        foreach ($validator->errors()->messages() as $key => $value) {
                $key = 'error_message';
                $errors[$key] = is_array($value) ? implode(',', $value) : $value;
        }

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'errors'    =>  $validator->errors(),
                'message'   =>  $errors['error_message'] ? $errors['error_message'] : __('msg.user.validation.fail'),
            ], 400 );
        }

        try {
            $forgotpassUser = DB::table('password_reset_tokens')->where('token', $req->otp)->first();
            
            if ($forgotpassUser) {
                $user = User::where('email', $forgotpassUser->email)->first();

                $user->password = Hash::make($req->password);
                $update = $user->save();

                if ($update) {
                    DB::table('password_reset_tokens')->where('token', '=', $req->otp)->delete();

                    return response()->json([
                            'status'    => 'success',
                            'message'   =>  trans('msg.reset-password.success'),
                        ], 200);
                } else {
                    return response()->json([
                            'status'    => 'failed',
                            'message'   =>  trans('msg.reset-password.failed'),
                        ],400
                    );
                }
            } else {
                return response()->json([
                        'status'    => 'failed',
                        'message'   =>  trans('msg.reset-password.otp-invalid'),
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

    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'password'   => 'required',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                    'status'    => 'failed',
                    'errors'    =>  $validator->errors(),
                    'message'   =>  trans('msg.validation'),
                ], 400
            );
        } 

        try {
            $service = new Services();
            $email = $req->email;
            $password = $req->password;
            $user  = User::where('email', '=', $email)->first();

            if(!empty($user)) 
            {
                if (Hash::check($password,$user->password)) {
                    if ($user->status == 'active') {
                        $claims = array(
                            'exp'   => Carbon::now()->addDays(1)->timestamp,
                            'uuid'  => $user->id
                        );

                        $token = $service->getSignedAccessTokenForUser($user, $claims);

                        $user->JWT_token = $token;
                        $user->save();

                        return response()->json(
                            [
                                'status'    => 'success',
                                'message'   =>   trans('msg.login.success'),
                                'data'      => $user,
                            ],200);
                    } else {
                        return response()->json(
                            [
                                'status'    => 'failed',
                                'message'   =>  trans('msg.login.inactive'),
                            ],400);
                    }
                }else {
                    return response()->json([
                            'status'    => 'failed',
                            'message'   =>  trans('msg.login.invalid'),
                    ], 400);
                }
            } else {
                return response()->json([
                        'status'    => 'failed',
                        'message'   =>  trans('msg.login.not-found'),
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

    public function socialRegister(Request $request)
    {
        $messages = [
            'fname.required' => 'First name is required.',
            'fname.max' => 'First name must not exceed :max characters.',
            // 'lname.required' => 'Last name is required.',
            // 'lname.max' => 'Last name must not exceed :max characters.',
            // 'country_code.required' => 'Country code is required.',
            
        ];

        $validator = Validator::make($request->all(), [
            'fname'     => ['string', 'max:255'],
            'email'     => ['required', 'email', 'max:255'],
            'photo' => ['nullable', 'image'],
            'social_type'   => [
                'required',
                Rule::in(['google','facebook']),
            ],
            // 'social_id'     => 'required',
        ], $messages);

        $errors = [];
        foreach ($validator->errors()->messages() as $key => $value) {
            $key = 'error_message';
            $errors[$key] = is_array($value) ? implode(',', $value) : $value;
        }

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'message'   => $errors['error_message'] ? $errors['error_message'] : trans('msg.validation'),
                'errors'    => $validator->errors()
            ], 400);
        }

        try {
            $user = User::where('email', $request->email)
                ->where('social_type', $request->social_type)
                ->first();

            if (!empty($user)) 
            {
                $service = new Services();
                $claims = array(
                    'exp'   => Carbon::now()->addDays(1)->timestamp,
                    'uuid'  => $user->id
                );

                $token = $service->getSignedAccessTokenForUser($user, $claims);

                $user->JWT_token = $token;
                $user->save();

                return response()->json(
                    [
                        'status'    => 'success',
                        'message'   =>   trans('msg.login.success'),
                        'data'      => $user,
                    ],200);
            } else {
                $newUser = new User();
                $newUser->email = $request->email;
                $newUser->social_type = $request->social_type;
                $newUser->is_social = '1';
                $newUser->fname = $request->fname;
                $newUser->is_verified = 'yes';
                
                $file = $request->file('photo');
                if ($file) {
                    if ($newUser->photo) {
                        $oldPhotoPath = public_path($newUser->photo);
            
                        if (file_exists($oldPhotoPath)) {
                            unlink($oldPhotoPath); 
                        }
                    }
                    $extension = $file->getClientOriginalExtension();
                    $image_name = time().'.'.$extension;
                    $file->move('assets/uploads/user-photos/', $image_name);
                    $image_url = 'assets/uploads/user-photos/'. $image_name;
                }
                
                if ($newUser->save()) {
                    $service = new Services();
                    $claims = array(
                        'exp'   => Carbon::now()->addDays(1)->timestamp,
                        'uuid'  => $newUser->id
                    );

                    $token = $service->getSignedAccessTokenForUser($newUser, $claims);

                    $newUser->JWT_token = $token;
                    $newUser->save();

                    $name = $user->fname.' '.$user->lname;
                    $message = [
                        'title' => trans('msg.notification.user_registered_title'),
                        'message' => trans('msg.notification.user_registered_message', ['name' => $name]),
                        'name' => $name,
                        'email' => $user->email,
                        'profile' => $image_url,
                    ];
    
                    $admin = Admin::where('role', '=', 'super_admin')->first();
                    $admin->notify(new AdminNotification($message));

                    return response()->json(
                        [
                            'status'    => 'success',
                            'message'   =>   trans('msg.login.success'),
                            'data'      => $newUser,
                        ],200);
                }
                else {
                    return response()->json([
                        'status' => 'failed',
                        'message' => trans('msg.registration.Notreg'),
                    ], 400);
                }
            }
        }
        catch (\Throwable $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => __('msg.error'),
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function socialLogin(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'password'   => 'required',
            'is_social'     => ['required', Rule::in(['0','1'])],
            'social_type'   => [
                'required',
                Rule::in(['google','facebook']),
            ],
            'social_id'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                    'status'    => 'failed',
                    'errors'    =>  $validator->errors(),
                    'message'   =>  trans('msg.validation'),
                ], 400
            );
        } 

        try {
            $service = new Services();
            $email = $req->email;
            $password = $req->password;
            $user  = User::where([['email','=',$req->email],['social_type','=',$req->social_type],['is_social','=',$req->is_social]])->first();

            if(!empty($user)) 
            {
                if (Hash::check($password,$user->password)) {
                    if ($user->status == 'active') {
                        $claims = array(
                            'exp'   => Carbon::now()->addDays(1)->timestamp,
                            'uuid'  => $user->id
                        );

                        $token = $service->getSignedAccessTokenForUser($user, $claims);

                        $user->JWT_token = $token;
                        $user->is_verified = 'yes';
                        $user->save();
                        // $user = User::where('email','=',$req->email)->update(['is_verified'=>'yes']);
                        return response()->json(
                            [
                                'status'    => 'success',
                                'message'   =>   trans('msg.login.success'),
                                'data'      => $user,
                            ],200);
                    } else {
                        return response()->json(
                            [
                                'status'    => 'failed',
                                'message'   =>  trans('msg.login.inactive'),
                            ],400);
                    }
                }else {
                    return response()->json([
                            'status'    => 'failed',
                            'message'   =>  trans('msg.login.invalid'),
                    ], 400);
                }
            } else {
                return response()->json([
                        'status'    => 'failed',
                        'message'   =>  trans('msg.login.not-found'),
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
