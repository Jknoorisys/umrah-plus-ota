<?php

namespace App\Http\Controllers\api\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use function App\Helpers\AuthUser;

class ProfileController extends Controller
{
    public function changePassword(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required',
            'currentpassword' => 'required',
            'newpassword'   => 'required',
            'confirmpassword' => 'required|same:newpassword',
        ]);

        if ($validator->fails()) {
            return response()->json([
                    'status'    => 'failed',
                    'errors'    =>  $validator->errors(),
                    'message'   =>  trans('msg.validation'),
                ], 400);
        } 

        try {
            
            $currentpassword = $req->currentpassword;
            $newpassword = $req->newpassword;
            $confirmpassword = $req->confirmpassword;
            $user  = user::where('id', '=', $req->user_id)->first();

            if(!empty($user)) 
            {
                if (Hash::check($currentpassword,$user->password)) {
                    $user->password = Hash::make($newpassword);
                    $user->save();
                        return response()->json(
                            [
                                'status'    => 'success',
                                'data' => $user,
                                'message'   =>   trans('msg.change-password.success'),
                            ],200);
                }else {
                    return response()->json([
                            'status'    => 'failed',
                            'message'   =>  trans('msg.change-password.invalid'),
                    ], 400);
                }
            } else {
                return response()->json([
                        'status'    => 'failed',
                        'message'   =>  trans('msg.change-password.not-found'),
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

    public function updateUserProfile(Request $req)
    {

    }
}
