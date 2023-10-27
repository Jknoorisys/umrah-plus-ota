<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use function App\Helpers\AuthUser;
use function App\Helpers\GetbillingAddress;
use App\Models\UserAddress;

class ProfileController extends Controller
{
    public function getProfile(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'user_id'   => ['required','alpha_dash', Rule::notIn('undefined')],
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status'    => 'failed',
                    'errors'    =>  $validator->errors(),
                    'message'   =>  trans('msg.validation'),
                ],400
            );
        }

        try {
            $user_id = $req->user_id;
            $user  = AuthUser($user_id);

            if (!empty($user) && $user->status != 'active') {
                return response()->json([
                       'status'    => 'failed',
                       'message'   =>  trans('msg.details.inactive'),
               ], 400);
            }

            if (!empty($user)) {
                $user->userAddress;
                return response()->json([
                    'status'    => 'success',
                    'message'   =>  trans('msg.details.success'),
                    'data'      => $user,
                ],200);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   =>  trans('msg.details.not-found'),
                ],400);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'failed',
                'message' =>  trans('msg.error'),
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function updateProfile(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'user_id'  => ['required','alpha_dash', Rule::notIn('undefined')],
            'fname'     => ['string', 'max:255'],
            'lname'     => ['string', 'max:255'],
            'email'     => ['email', 'max:255', Rule::unique('users')->ignore($request->user_id)],
            'phone'     => ['numeric', Rule::unique('users')->ignore($request->user_id)],
            'country_code' => ['string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors(),
            ], 400);
        } 

        try {
            $user = AuthUser($request->user_id);
            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/uploads/user-photos'), $imageName);
                $user->photo = $imageName;
            }
            
            $data = [
                'fname'     => $request->input('fname', $user->fname),
                'lname'     => $request->input('lname', $user->lname),
                'email'     => $request->input('email', $user->email),
                'country_code' => $request->input('country_code', $user->country_code),
                'phone'     => $request->input('phone', $user->phone),
                'photo' => $request->photo ? 'assets/uploads/user-photos/'.$user->photo : 'assets/uploads/user-photos/'.$user->photo,
            ];
    
            $update = $user->update($data);
    
            if ($update) {
                $user->fresh();
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.update.success'),
                    'data'      => $user,
                ], 200);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.update.failed'),
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

    public function uploadPhoto(Request $request) {
        $validator = Validator::make($request->all(), [
            'user_id'  => ['required','alpha_dash', Rule::notIn('undefined')],
            'photo'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors(),
            ], 400);
        } 

        try {
            $user = AuthUser($request->user_id);
    
            $data = [];
    
            $file = $request->file('photo');
            if ($file) {
                if ($user->photo) {
                    $oldPhotoPath = public_path($user->photo);
        
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath); 
                    }
                }
        
                $extension = $file->getClientOriginalExtension();
                $image_name = time().'.'.$extension;
                $upload = $file->move('assets/uploads/user-photos/', $image_name);
                $image_url = 'assets/uploads/user-photos/'. $image_name;
                $data['photo'] = $image_url;
            }
    
            $logo = $request->file('logo'); 
            if ($logo) {
                if ($user->logo) {
                    $oldLogoPath = public_path($user->logo);
        
                    if (file_exists($oldLogoPath)) {
                        unlink($oldLogoPath); 
                    }
                }

                $extension = $logo->getClientOriginalExtension();
                $logo_name = time().'.'.$extension;
                $upload = $logo->move('assets/uploads/user-logos/', $logo_name);
                $logo_url = 'assets/uploads/user-logos/'. $logo_name;
                $data['logo'] = $logo_url; 
            }
    
            $update = $user->update($data);
    
            if ($update) {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.update.success'),
                    'data'      => $user,
                ], 200);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.update.failed'),
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

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'   => ['required','alpha_dash', Rule::notIn('undefined')],            
            'old_password' => 'required',
            'new_password'   => ['required', 'min:8', 'max:20'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors(),
            ], 400);
        } 

        try {
            
            $old_password = $request->old_password;
            $new_password = $request->new_password;
            $user  = AuthUser($request->user_id);

            if(!empty($user)) 
            {
                if (Hash::check($old_password, $user->password)) {

                    $user->password = Hash::make($new_password);
                    $update = $user->save();

                    if ($update) {
                        return response()->json([
                            'status'    => 'success',
                            'message'   => trans('msg.change-password.success'),
                            'data'      => $user,
                        ], 200);
                    } else {
                        return response()->json([
                            'status'    => 'failed',
                            'message'   => trans('msg.change-password.failed'),
                        ], 400);
                    }
                } else {
                    return response()->json([
                        'status'    => 'failed',
                        'message'   => trans('msg.change-password.invalid'),
                    ], 400);
                }
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.change-password.not-found'),
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

    public function address(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'user_id'   => ['required','alpha_dash', Rule::notIn('undefined')],            
            'address_line' => ['string','max:255'],
            'pin_code' => ['numeric'],
            'city' => ['string','max:255'],
            'state' => ['string','max:255'],
            'country' => ['string','max:255']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors(),
            ], 400);
        } 

        try {
            $user  = AuthUser($req->user_id);
            if(!empty($user)) 
            {
                $prevadd = GetbillingAddress($req->user_id);
                if(!empty($prevadd))
                {
                    $data = [
                        'address' => $req->address_line ? $req->address_line : $prevadd->address,
                        'pin_code' => $req->pin_code ? $req->pin_code : $prevadd->pin_code,
                        'city' => $req->city ? $req->city : $prevadd->city,
                        'state' => $req->state ? $req->state : $prevadd->state,
                        'country' => $req->country ? $req->country : $prevadd->country,
                    ];
                  
                    $address = $prevadd->update($data);
                    
                    if($address)
                    {
                        return response()->json([
                            'status'    => 'success',
                            'data' => $prevadd,
                            'message'   => trans('msg.billing-address.success'),
                        ], 200);
                    }
                    else{
                        return response()->json([
                            'status'    => 'failed',
                            'message'   => trans('msg.billing-address.failed'),
                        ], 400);
                    }

                }
                else{
                    $data = [
                        'user_id' => $req->user_id,
                        'address' => $req->address_line,
                        'pin_code' => $req->pin_code,
                        'city' => $req->city,
                        'state' => $req->state,
                        'country' => $req->country,
                    ];
                  
                    $address = UserAddress::create($data);
                    if($address)
                    {
                        return response()->json([
                            'status'    => 'success',
                            'data' => $prevadd,
                            'message'   => trans('msg.billing-address.added'),
                        ], 200);
                    }
                    else{
                        return response()->json([
                            'status'    => 'failed',
                            'message'   => trans('msg.billing-address.add-failed'),
                        ], 400);
                    }
                }
                
            }
            else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.change-password.not-found'),
                ], 400);
            }

        }
        catch (\Throwable $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => trans('msg.error'),
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    

    
}
