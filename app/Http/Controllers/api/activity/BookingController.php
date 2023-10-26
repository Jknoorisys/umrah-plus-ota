<?php

namespace App\Http\Controllers\api\activity;

use App\Http\Controllers\Controller;
use App\Models\PromoCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use function App\Helpers\AuthUser;

class BookingController extends Controller
{
    public function calculateSignature()
    {
        // Retrieve the public key, private key, and UTC date from your Laravel environment or configuration.
        $publicKey = config('constants.activites.Api-key');
        $privateKey = config('constants.activites.secret');
        $utcDate = time(); // Current UTC timestamp in seconds

        // Combine the public key, private key, and UTC date as in the JavaScript code.
        $assemble = $publicKey . $privateKey . $utcDate;

        // Calculate SHA-256 hash using HMAC
        $assemble = $publicKey . $privateKey . $utcDate;

        // Calculate the SHA-256 hash
        $hash = hash('sha256', $assemble);

        // Set the X-Signature in your response headers
        return $hash;
    }

    public function ActivityPromoCode(Request $request)
    {
        try{

            $promocode = PromoCodes::where('service','=','activity')->get();
            if(!empty($promocode))
            {
                return response()->json([
                    'status' => 'success',
                    'message' => trans('msg.list.success'),
                    'data' => $promocode,
                ], 200);
            } else {
                
                return response()->json([
                    'status' => 'failed',
                    'message' => trans('msg.list.failed'),
                    'data' => $promocode,
                ], 400); 
            }

        }catch (\Throwable $e) {
            return response()->json([
                'status' => 'failed',
                'message' => trans('msg.error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    // app/Http/Controllers/PromoCodeController.php
    public function validatePromoCode(Request $request) 
    {
        try{

            $validator = Validator::make($request->all(), [
                'code' => ['required'],
                'user_id' => ['required'],
                
                        ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }

            $promoCode = PromoCodes::where('code', $request->input('code'))->first();

        if (!$promoCode) {
            return response()->json(['message' => 'Invalid promo code'], 404);
        }

        if ($promoCode->isExpired()) {
            return response()->json(['message' => 'Promo code has expired'], 422);
        }

        $user = AuthUser($request->user_id); 

        if ($promoCode->hasUserReachedMaxUsage($user)) {
            return response()->json(['message' => 'User has reached the maximum usage for this promo code'], 422);
        }

        return response()->json(['message' => 'Promo code is valid']);
        }
        catch (\Throwable $e) {
            return response()->json([
                'status' => 'failed',
                'message' => trans('msg.error'),
                'error' => $e->getMessage(),
            ], 500);
        }
        
    }


    public function filterActivities(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'filters' => ['required','array'],
                'paxes' => ['array'],
                'from' => ['date'],
                'to' => ['date'],
                'language' => ['string'],
                'pagination' => ['array'],
                'order' => ['string'],
                // 'codes' => 'string'
                        ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }
            // echo json_encode($request->all());exit;
            $languages =  $request->input('language');
            $activateMigration = $request->input('activateMigration');
            $filters = $request->input('filters');
            $paxes = $request->input('paxes');
            $from = $request->input('from');
            $to = $request->input('to');
            $pagination = $request->input('pagination');
            $order = $request->input('order');
            // $codes = $request->input('codes');

            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->post(config('constants.end-point') . '/activity-api/3.0/activities/', [
                            'activationMigration' => $activateMigration,
                            'filters' => $filters,
                            'paxes' => $paxes,
                            'from' => $from,
                            'to' => $to,
                            'language' => $languages,
                            'pagination' => $pagination,
                            'order' => $order,
                            // 'codes' => $codes
                        ]);
                        // echo json_encode($filters);exit;
            $status = $response->status();

            if ($status === 200) {
                $responseData = $response->json();

                return response()->json([
                    'status' => 'success',
                    'message' => trans('msg.list.success'),
                    'data' => $responseData,
                ], $status);
            } else {
                $responseData = $response->json();

                return response()->json([
                    'status' => 'failed',
                    'message' => trans('msg.list.failed'),
                    'data' => $responseData,
                ], $status);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failed',
                'message' => trans('msg.error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function Booking_Detail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'code' => ['required'],
                'paxes' => ['array'],
                'from' => ['date'],
                'to' => ['date'],
                'language' => ['string'],
                'modalityCode' => ['string'],
                'pickup' => ['array']
                        ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }
            // echo json_encode($request->all());exit;
            $languages = $request->input('language');
            $paxes = $request->input('paxes');
            $from = $request->input('from');
            $to = $request->input('to');
            $order = $request->input('order');
            $code = $request->input('code');
            $modalityCode = $request->input('modalityCode');
            $pickup = $request->input('pickup');

            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->post(config('constants.end-point') . '/activity-api/3.0/activities/details/', [
                            
                            // 'modalityCode' => $modalityCode,
                            'code' => $code,
                            'paxes' => $paxes,
                            'from' => $from,
                            'to' => $to,
                            'language' => $languages,
                            'pickup' => $pickup,
                        ]);
                        // echo json_encode($filters);exit;
            $status = $response->status();

            if ($status === 200) {
                $responseData = $response->json();

                return response()->json([
                    'status' => 'success',
                    'message' => trans('msg.list.success'),
                    'data' => $responseData,
                ], $status);
            } else {
                $responseData = $response->json();

                return response()->json([
                    'status' => 'failed',
                    'message' => trans('msg.list.failed'),
                    'data' => $responseData,
                ], $status);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failed',
                'message' => trans('msg.error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function Detail_full(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'code' => ['required'],
                'paxes' => ['array'],
                'from' => ['date'],
                'to' => ['date'],
                'language' => ['string'],
                        ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }
            // echo json_encode($request->all());exit;
            $languages = $request->input('language');
            $paxes = $request->input('paxes');
            $from = $request->input('from');
            $to = $request->input('to');
            $order = $request->input('order');
            $code = $request->input('code');

            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->post(config('constants.end-point') . '/activity-api/3.0/activities/details/full/', [
                            
                            'code' => $code,
                            'paxes' => $paxes,
                            'from' => $from,
                            'to' => $to,
                            'language' => $languages,
                        ]);
                        // echo json_encode($filters);exit;
            $status = $response->status();

            if ($status === 200) {
                $responseData = $response->json();

                return response()->json([
                    'status' => 'success',
                    'message' => trans('msg.list.success'),
                    'data' => $responseData,
                ], $status);
            } else {
                $responseData = $response->json();

                return response()->json([
                    'status' => 'failed',
                    'message' => trans('msg.list.failed'),
                    'data' => $responseData,
                ], $status);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failed',
                'message' => trans('msg.error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function retrivePickup(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'pickupRetrievalKey' => ['required'],
                'from' => ['date'],
                'to' => ['date'],
                'pagination' => 'array',

                        ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }
            // echo json_encode($request->all());exit;
           
            $from = $request->input('from');
            $to = $request->input('to');
            $pickupRetrievalKey = $request->input('pickupRetrievalKey');
            $pagination = $request->input('pagination');

            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->post(config('constants.end-point') . '/activity-api/3.0/activities/excursions/retrievePickups', [
                            'from' => $from,
                            'to' => $to,
                            'pickupRetrievalKey' => $pickupRetrievalKey,
                            'pagination' => $pagination,
                        ]);
                        // echo json_encode($filters);exit;
            $status = $response->status();

            if ($status === 200) {
                $responseData = $response->json();

                return response()->json([
                    'status' => 'success',
                    'message' => trans('msg.list.success'),
                    'data' => $responseData,
                ], $status);
            } else {
                $responseData = $response->json();

                return response()->json([
                    'status' => 'failed',
                    'message' => trans('msg.list.failed'),
                    'data' => $responseData,
                ], $status);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failed',
                'message' => trans('msg.error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    } 
    
    public function Availability(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'destination' => ['required'],
                'offset' => ['required'],
                'limit' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }
            $data = [];
            $data['destination'] = $request->input('destination');
            $data['offset'] = $request->input('offset');
            $data['limit'] = $request->input('limit');
            $queryString = http_build_query($data);
            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point') . '/activity-cache-api/1.0/avail/'.$queryString);
                        // echo json_encode(config('constants.end-point') . '/activity-cache-api/1.0/avail/'.$queryString);exit;
            $status = $response->status();
            if ($status === 200) {
                $responseData = $response->json();
                // echo json_encode($responseData);exit;

                return response()->json([
                    'status' => 'success',
                    'message' => trans('msg.list.success'),
                    'data' => $responseData,
                ], $status);
            } else {
                $responseData = $response->json();

                return response()->json([
                    'status' => 'failed',
                    'message' => trans('msg.list.failed'),
                    'data' => $responseData,
                ], $status);
            }

        }
        catch (\Throwable $e) {
            return response()->json([
                'status' => 'failed',
                'message' => trans('msg.error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function BookingConfirm(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'language' => 'required|json',
                'holder'  => 'required|json',
                'activities'   => 'required|json',
                'clientReference' => 'required|json',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }
            // echo json_encode($request->all());exit;
            $data = [
                "holder" => json_decode($request->holder, TRUE),
                "activities" => json_decode($request->activities, TRUE),
                'clientReference' => json_decode($request->clientReference, TRUE),
                'language' => json_decode($request->language, TRUE),
            ];
            $queryString = http_build_query($data);
            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point') . '/activity-api/3.0/bookings'.$queryString);
            echo json_encode(config('constants.end-point') . '/activity-api/3.0/bookings/'.$queryString);exit;
            $status = $response->status();
            if ($status === 200) {
                $responseData = $response->json();
                // echo json_encode($responseData);exit;

                return response()->json([
                    'status' => 'success',
                    'message' => trans('msg.list.success'),
                    'data' => $responseData,
                ], $status);
            } else {
                $responseData = $response->json();

                return response()->json([
                    'status' => 'failed',
                    'message' => trans('msg.list.failed'),
                    'data' => $responseData,
                ], $status);
            }

        }
        catch (\Throwable $e) {
            return response()->json([
                'status' => 'failed',
                'message' => trans('msg.error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    
}
