<?php

    namespace App\Helpers;

    
    use App\Models\User;
    use App\Models\UserAddress;

    function AuthUser($user_id) {
        $user  = User::where([['id', '=', $user_id], ['is_verified', '=', 'yes']])->first();

        if (empty($user)) {
                return response()->json([
                    'status'    => 'failed',
                    'message'   =>  trans('msg.login.not-found'),
            ], 400);
        }

        return $user;
    }

    function GetbillingAddress($user_id)
    {
        $address = UserAddress::where([['user_id', '=', $user_id]])->first();
        return $address;
    }

    