<?php

use App\Http\Controllers\api\admin\AuthController;
use App\Http\Controllers\api\admin\ProfileController;
use App\Http\Controllers\api\hotels\BookingController;
use App\Http\Controllers\api\transfer\BookingController as TransferBookingController;
use App\Http\Controllers\api\activity\BookingController as ActivityBookingController;
use App\Http\Controllers\api\hotels\ContentController;
use App\Http\Controllers\api\transfer\ContentController as TransferContentController;
use App\Http\Controllers\api\activity\ContentController as ActivityContentController;
use App\Http\Controllers\api\master\HotelMasterController;
use App\Http\Controllers\api\umrah\UmrahController;
use App\Http\Controllers\api\umrah\ZiyaratController;
use App\Http\Controllers\api\promocode\PromoCodeController;
use App\Http\Controllers\api\user\AuthController as UserAuthController;
use App\Http\Controllers\api\user\ProfileController as UserProfileController;
use App\Http\Controllers\api\hotels\payments\PaymentController as HotelPaymentController;
use App\Http\Controllers\api\activity\payments\PaymentController as ActivityPaymentController;
use App\Http\Controllers\api\transfer\payments\PaymentController as TransferPaymentController;
use App\Http\Controllers\api\visa\VisaController;
use App\Http\Controllers\api\ziyarat\ZiyaratController as EnquiryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['localization'])->group(function () {
    
    // Admin APIs by Javeriya
    Route::prefix('admin')->group(function () {
        Route::post('login' , [AuthController::class, 'login']);
        Route::group(['middleware' => 'jwt.verify'], function () {
            Route::post('change-password', [ProfileController::class, 'changePassword']);
            Route::post('profile', [ProfileController::class, 'getProfile']);
        });
    });

    // User APIs by Aaisha
    Route::prefix('user')->group(function () {
        Route::post('register' , [UserAuthController::class, 'register']);
        Route::post('socialRegister' , [UserAuthController::class, 'socialRegister']);
        Route::post('verifyOTP',[UserAuthController::class,'verifyOTP']);
        Route::post('resendregOTP',[UserAuthController::class,'resendRegOTP']);
        Route::post('login' , [UserAuthController::class, 'login']);
        Route::post('socialLogin' , [UserAuthController::class, 'socialLogin']);
        Route::post('forgetpassword' , [UserAuthController::class, 'forgetpassword']);
        Route::post('forgotPasswordValidate',[UserAuthController::class,'forgotPasswordValidate']);

        Route::group(['middleware' => 'jwt.verify'], function () {
            Route::post('profile' , [UserProfileController::class, 'getProfile']);
            Route::post('changepassword', [UserProfileController::class, 'changePassword']);
            Route::post('updateProfile', [UserProfileController::class, 'updateProfile']);
            Route::post('uploadPhoto', [UserProfileController::class, 'uploadPhoto']);
            Route::post('address', [UserProfileController::class, 'address']);
        });
    
    });

    // Transfer APIs by Aaisha
    Route::prefix('transfer-api')->group(function () {
        // AVAILABILITY
        Route::post('countries' , [TransferContentController::class, 'countries']);
        Route::post('terminals' , [TransferContentController::class, 'terminals']);
        Route::post('destinations' , [TransferContentController::class, 'destinations']);
        Route::post('categories' , [TransferContentController::class, 'categories']);
        Route::post('vehicals' , [TransferContentController::class, 'vehicals']);
        Route::post('transferTypes' , [TransferContentController::class, 'transferTypes']);
        Route::post('currencies' , [TransferContentController::class, 'currencies']);
        Route::post('routes' , [TransferContentController::class, 'routes']);
        Route::post('hotels' , [TransferContentController::class, 'hotels']);
        Route::post('pickup' , [TransferContentController::class, 'pickup']);

        // Availability
        Route::post('availability' , [TransferBookingController::class, 'availability']);
        Route::post('AvailableRoutes' , [TransferBookingController::class, 'AvailableRoutes']);

        // BOOKING
        Route::post('confirmBooking' , [TransferBookingController::class, 'confirmBooking']);

        // POST BOOKING
        Route::get('bookingList' , [TransferBookingController::class, 'bookingList']);
        Route::get('bookingDetail' , [TransferBookingController::class, 'bookingDetail']);
        Route::post('booking-change' , [TransferBookingController::class, 'bookingChange']);
        Route::delete('booking-cancel' , [TransferBookingController::class, 'bookingCancel']);
        Route::post('reconfirmations' , [TransferBookingController::class, 'bookingReconfirmation']);
    });

    // Activities APIs by Aaisha
    Route::prefix('activity-api')->group(function() {
        Route::post('languages' , [ActivityContentController::class, 'languages']);
        Route::post('currencies' , [ActivityContentController::class, 'currencies']);
        Route::post('segments' , [ActivityContentController::class, 'segments']);
        Route::post('countries' , [ActivityContentController::class, 'countries']);
        Route::post('destinations' , [ActivityContentController::class, 'destinations']);
        Route::post('content_single' , [ActivityContentController::class, 'content_single']);
        Route::post('content_multi' , [ActivityContentController::class, 'content_multi']);
        Route::post('hotels' , [ActivityContentController::class, 'hotels']);
        Route::post('filterActivities' , [ActivityBookingController::class, 'filterActivities']);
        Route::post('Booking_Detail' , [ActivityBookingController::class, 'Booking_Detail']);
        Route::post('Detail_full' , [ActivityBookingController::class, 'Detail_full']);
        Route::post('retrivePickup' , [ActivityBookingController::class, 'retrivePickup']);
        Route::post('Availability' , [ActivityBookingController::class, 'Availability']);
        Route::post('BookingConfirm' , [ActivityBookingController::class, 'BookingConfirm']);
        Route::post('PreConfirmBoooking' , [ActivityBookingController::class, 'PreConfirmBoooking']);
        Route::post('ReConfirmBooking' , [ActivityBookingController::class, 'ReConfirmBooking']);
        Route::post('BookingList' , [ActivityBookingController::class, 'BookingList']);
        Route::post('BookingDetails' , [ActivityBookingController::class, 'BookingDetails']);
        Route::post('BookingDetailOptions' , [ActivityBookingController::class, 'BookingDetailOptions']);
        Route::post('ConfirmedBookingListFilter' , [ActivityBookingController::class, 'ConfirmedBookingListFilter']);
        Route::post('CancelBooking' , [ActivityBookingController::class, 'CancelBooking']);
        
        
    });
  
    // Hotels APIs by Javeriya
    Route::prefix('hotel-api')->group(function () {
        // AVAILABILITY
        Route::post('hotels' , [BookingController::class, 'hotels']);

        // CHECK RATE
        Route::post('checkrates' , [BookingController::class, 'checkrates']);

        // BOOKING
        Route::post('bookings' , [BookingController::class, 'bookings']);

        // POST BOOKING
        Route::get('booking-list' , [BookingController::class, 'bookingList']);
        Route::get('booking-details' , [BookingController::class, 'bookingDetails']);
        Route::post('booking-change' , [BookingController::class, 'bookingChange']);
        Route::delete('booking-cancel' , [BookingController::class, 'bookingCancel']);
        Route::post('reconfirmations' , [BookingController::class, 'bookingReconfirmation']);
    });

    Route::prefix('hotel-content-api')->group(function () {
        // HOTELS
        Route::get('hotels' , [ContentController::class, 'hotels']);
        Route::get('hotels-aaisha' , [ContentController::class, 'hotels_aaisha']);
        Route::get('hotel-details' , [ContentController::class, 'hotelDetails']);

        // LOCATIONS
        Route::get('countries' , [ContentController::class, 'countries']);
        Route::get('destinations' , [ContentController::class, 'destinations']);

        // TYPES
        Route::get('accommodations' , [ContentController::class, 'accommodations']);
        Route::get('boards' , [ContentController::class, 'boards']);
        Route::get('categories' , [ContentController::class, 'categories']);
        Route::get('chains' , [ContentController::class, 'chains']);
        Route::get('currencies' , [ContentController::class, 'currencies']);
        Route::get('facilities' , [ContentController::class, 'facilities']);
        Route::get('facilitygroups' , [ContentController::class, 'facilitygroups']);
        Route::get('facilitytypologies' , [ContentController::class, 'facilitytypologies']);
        Route::get('issues' , [ContentController::class, 'issues']);
        Route::get('languages' , [ContentController::class, 'languages']);
        Route::get('promotions' , [ContentController::class, 'promotions']);
        Route::get('rooms' , [ContentController::class, 'rooms']);
        Route::get('segments' , [ContentController::class, 'segments']);
        Route::get('terminals' , [ContentController::class, 'terminals']);
        Route::get('imagetypes' , [ContentController::class, 'imagetypes']);
        Route::get('groupcategories' , [ContentController::class, 'groupcategories']);
        Route::get('ratecomments' , [ContentController::class, 'ratecomments']);
        Route::get('ratecommentdetails' , [ContentController::class, 'ratecommentdetails']);
    });

    // Master APIs by Javeriya
    Route::prefix('master')->group(function () {
        Route::get('countries' , [HotelMasterController::class, 'countries']);
        Route::get('languages' , [HotelMasterController::class, 'languages']);
        Route::get('hotels' , [HotelMasterController::class, 'hotels']);
        Route::post('countries' , [HotelMasterController::class, 'countries']);
        Route::post('languages' , [HotelMasterController::class, 'languages']);
        Route::post('hotels' , [HotelMasterController::class, 'hotels']);
        Route::post('destinations' , [HotelMasterController::class, 'destinations']);
        Route::post('currencies' , [HotelMasterController::class, 'currencies']);
    });

    // Umrah Packages API by Javeriya
    Route::prefix('umrah')->group(function () {
        Route::post('list' , [UmrahController::class, 'list']);
        Route::post('view' , [UmrahController::class, 'view']);
        Route::post('send-enquiry' , [UmrahController::class, 'sendEnquiry'])->middleware('jwt.verify');

    });

    // Ziyarat Packages API by Javeriya
    Route::prefix('ziyarat')->group(function () {
        Route::post('list' , [ZiyaratController::class, 'list']);
        Route::post('sendEnquiry' , [EnquiryController::class, 'sendEnquiry'])->middleware('jwt.verify');
    });

    Route::prefix('promocode')->group(function () {
        Route::post('list' , [PromoCodeController::class, 'GetPromoCode']);
        Route::post('validate' , [PromoCodeController::class, 'validatePromoCode']);
    });

    Route::prefix('visa')->group(function () {
        Route::post('visa-packages' , [VisaController::class, 'getVisaPackages']);
        Route::post('visa-package-details' , [VisaController::class, 'getVisaPackage']);
        Route::post('send-enquiry' , [VisaController::class, 'sendEnquiry'])->middleware('jwt.verify');
    });

});

