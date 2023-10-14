<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Message Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during Message for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'admin' => [

        // Login
        'Login' => 'Login',
        'Welcome Back!' => 'Welcome Back!',
        'hello' => 'Hello :fname :lname!',
        'Please login first' => 'Please login first',        
        'Email' => 'Email',
        'Email Address' => 'Email Address',
        'Enter Password' => 'Enter Password',
        'Enter Valid Password' => 'Enter Valid Password',
        'Password' => 'Password',
        'Forgot Password' => 'Forgot Password',
        'Invalid Password'  => 'Invalid Password',
        'Admin Not Found'  => 'Admin Not Found',
        'Invalid credentials'  => 'Invalid credentials',

        // Header
        'Logout'  => 'Logout',
        'Profile' => 'Profile',
        'Settings' => 'Settings',

        // Sidebar
        'Dashboard' => 'Dashboard',

        // Profile
        'First Name' => 'First Name',
        'Last Name' => 'Last Name',
        'Email' => 'Email',
        'Country' => 'Country',
        'Phone' => 'Phone',
        'Profile Image' => 'Profile Image',
        'Enter Valid First Name' => 'Enter Valid First Name',
        'Enter Valid Last Name' => 'Enter Valid Last Name',
        'Enter Valid Email Address' => 'Enter Valid Email Address',
        'Select Country Code' => 'Select Country Code',
        'Enter Mobile Number' => 'Enter Mobile Number',
        'Profile Updated Successfully' => 'Profile Updated Successfully',
        'Unable to Update, Please try again...' => 'Unable to Update, Please try again...',
        'Save Changes' => 'Save Changes',
        'Cancel' => 'Cancel',

        // Change Password
        'Change Password' => 'Change Password',
        'Current Password' => 'Current Password',
        'New Password' => 'New Password',
        'Confirm Password' => 'Confirm Password',
        'Enter Current Password' => 'Enter Current Password',
        'Enter New Password' => 'Enter New Password',
        'Current password is Incorrect' => 'Current password is Incorrect',     
        'Password Changed Successfully' => 'Password Changed Successfully',
        'Unable to change password. Please try again' => 'Unable to change password. Please try again', 
        
        // Forgot Password
        'Forgot Password' => 'Forgot Password',
        'Back to Login' => 'Back to Login',
        'Enter your registered Email ID to reset the password' => 'Enter your registered Email ID to reset the password',
        'Send' => 'Send',

        // Reset Password
        'Genrate New Password' => 'Genrate New Password',
        'We received your reset password request, Please enter your new password' => 'We received your reset password request, Please enter your new password',
        'New Password' => 'New Password',
        'Enter new password' => 'Enter new password',
        'Enter confirm password' => 'Enter confirm password',

        // Manage Users
        'Manage Users' => 'Manage Users',
    ],

    'localization' => 'Accept-Language header is required',
    'validation'   => 'Validation Failed!',
    'error'        => 'Something went wrong, please try again...',
     
    'jwt' => [
        'TokenNotSet' => 'Bearer Token Not Set',
        'InvalidToken' => 'Invalid Bearer Token',
        'expiredToken' => 'Bearer Token Expired!',
        'TokenNotFound' => 'Bearer Token Not Found'
    ],

    'email' => [
        'registration' => [
            'subject' => 'Email Verification',
            'greeting' => 'Hello :name!',
            'email' => 'Your Email: :email',
            'password' => 'Your Password: :password',
            'otp' => 'Your OTP: :otp',
            'keep_secure' => 'Please keep your credentials secure.',
            'login' => 'Login',
            'thank_you' => 'Thank you for using our service!',
        ],

        'reset-password' => [
            'subject' => 'Reset Password',
            'greeting' => 'Hello :name!',
            'message' => 'You have requested to reset your password. Below is your reset password OTP (One-Time Password)!',
            'otp' => 'Your OTP: :otp',
            'keep_secure' => 'Please keep your credentials secure.',
            'login' => 'Login',
            'thank_you' => 'Thank you for using our service!',
        ],
    ],

    'notification' => [
        'user_registered_title' => 'User Registration',
        'user_registered_message' => ':name registered successfully.',
        'password_reset_request' => ':email have requested to reset his/her password',
        'password_reset_title' => 'Reset Password Request',

    ],

    'registration' => [
        'success' => 'Registration Successful',
        'failed'  => 'Registration Failed',
        'email-verified' => 'Email Already Verified',
        'mobile-exist' => 'Mobile Number Already Exist',
        'otp-sent' => 'OTP Sent Successfully',
        'otp-failed' => 'OTP Sending Failed',
        'otp-invalid' => 'Invalid OTP',
        'otp-verified' => 'OTP Verified Successfully',
        'not-found' => 'User Not Found, Please Register First...',
        'inactive' => 'Account blocked by Admin',
    ],

    'reset-password' => [
        'success' => 'Password Reset Successfully',
        'failed'  => 'Password Reset Failed',
        'not-found' => 'User Not Found, Please Register First...',
        'otp-invalid' => 'Invalid OTP',
        'otp-verified' => 'OTP Verified Successfully',
        'otp-sent' => 'OTP Sent Successfully',
        'otp-failed' => 'OTP Sending Failed',
    ],

    'list' => [
        'success' => 'List Fetched Successfully',
        'failed'  => 'No Data Found',
    ],

    'add' => [
        'success' => 'Details Added Successfully',
        'failed'  => 'Add Failed',
    ],

    'delete' => [
        'success' => 'Record Deleted Successfully',
        'failed'  => 'Delete Failed',
    ],

    'update' => [
        'success' => 'Details Updated Successfully',
        'failed'  => 'Update Failed',
        'not-found' => 'User Not Found',
    ],

    'booking' => [
        'success' => 'Booking Successful',
        'failed'  => 'Booking Failed',
    ],

    'booking-cancel' => [
        'success' => 'Booking Cancelled',
        'failed'  => 'Booking Cancellation Failed',
    ],

    'detail' => [
        'success' => 'Details Fetched Successfully',
        'failed'  => 'Details Not Found',
        'not-found' => ':entity not found',
        'inactive' => 'Account blocked by Admin',
    ],   

    'login' => [
        'success' => 'Login Successful',
        'failed'  => 'Login Failed',
        'not-found' => 'User Not Found, Please Register First...',
        'invalid' => 'Password Does Not Match!',
        'inactive' => 'Account blocked by Admin',
        'not-verified' => 'Email not Verified, please verify it first...',
        'not-social' => 'Unable to Find Social Account',
        'invalid-social' => 'Social Id Does Not Match, Please try again...',
        'invalid-email' => 'Invalid Email Address',
    ],

    'change-password' => [
        'success' => 'Password Updated Successfully',
        'failed'  => 'Unable to update Password, please try again...',
        'not-found' => 'User Not Found, Please Register First...',
        'invalid' => 'Old Password Does Not Match!',
        'inactive' => 'Account blocked by Admin',
        'not-verified' => 'Email not Verified, please verify it first...'
    ],

    'change-status' => [
        'success' => 'Status Updated Successfully',
        'failed'  => 'Unable to update status, please try again...',
        'not-found' => ':entity is not found',        
        'inactive' => 'Account blocked by Admin',
        'not-verified' => 'Email not Verified, please verify it first...'
    ],

    'billing-address' => 
        [
            'success' => 'Billing Address Updated Successfully',
            'failed'  => 'Unable to update Billing Address, please try again...',
            'added' => 'Billing Address Added Successfully',
            'add-failed' => 'Unable to add Billing Address, please try again...',
        ]
];
