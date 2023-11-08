<?php

namespace App\Http\Controllers\api\activity;

use App\Http\Controllers\Controller;
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
    
    // public function Availability(Request $request)
    // {
    //     try{
    //         $validator = Validator::make($request->all(), [
    //             'destination' => ['required'],
    //             'offset' => ['required'],
    //             'limit' => ['required'],
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => 'failed',
    //                 'errors' => $validator->errors(),
    //                 'message' => trans('msg.validation'),
    //             ], 400);
    //         }
    //         $data = [
    //             'destination' => $request->destination,
    //             'limit' => $request->limit,
    //             'offset' => $request->offset,
            
    //         ];
            
    //         $queryString = http_build_query($data);
    //         $signature = self::calculateSignature();
    //         $response = Http::withHeaders([
    //             'Api-key' => config('constants.activites.Api-key'),
    //             'X-Signature' => $signature,
    //             'Accept' => 'application/json',
    //             'Content-Type' => 'application/json',
    //         ])->get(config('constants.end-point') . '/activity-api/1.0/avail',$data);
    //             // echo json_encode($signature);exit;
    //         $status = $response->status();
    //         if ($status === 200) {
    //             $responseData = $response->json();
            

    //             return response()->json([
    //                 'status' => 'success',
    //                 'message' => trans('msg.list.success'),
    //                 'data' => $responseData,
    //             ], $status);
    //         } else {
    //             $responseData = $response->json();

    //             return response()->json([
    //                 'status' => 'failed',
    //                 'message' => trans('msg.list.failed'),
    //                 'data' => $responseData,
    //             ], $status);
    //         }

    //     }
    //     catch (\Throwable $e) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => trans('msg.error'),
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function Availability(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'filters' => ['required','array'],
                'paxes' => ['array'],
                'from' => ['date'],
                'to' => ['date'],
                'language' => ['string'],
                'pagination' => ['array'],
                'order' => ['string'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }
            // $data = [
            //     'filters' => $request->filter,
            //     'from' => $request->from,
            //     'to' => $request->to,
            //     'paxes' => $request->paxes,
            //     'language' => $request->language,
            //     'pagination' => $request->pagination,
            //     'order' => $request->order,
            
            // ];

            $languages =  $request->input('language');
            $filters = $request->input('filters');
            $paxes = $request->input('paxes');
            $from = $request->input('from') ? $request->input('from') : '';
            $to = $request->input('to') ? $request->input('to') : '';
            $pagination = $request->input('pagination');
            $order = $request->input('order');
            
            // $queryString = http_build_query($data);
            $signature = self::calculateSignature();
            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post(config('constants.end-point') . '/activity-api/3.0/activities/availability',[
                            'filters' => $filters,
                            'paxes' => $paxes,
                            'from' => $from,
                            'to' => $to,
                            'language' => $languages,
                            'pagination' => $pagination,
                            'order' => $order,
            ]);
            // $total = $response['activities'];
            // $data = count($total);
            // echo json_encode($data);exit;

            $status = $response->status();
            if ($status === 200) {
                $responseData = $response->json();
            

                return response()->json([
                    'status' => 'success',
                    'message' => trans('msg.list.success'),
                    // 'total' => $data,
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
                'language' => 'required',
                'holder'  => 'required|json',
                'activities'   => 'required|json',
                'clientReference' => 'required',
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
                'clientReference' => $request->clientReference,
                'language' => $request->language,
            ];
            // echo json_encode($data);exit;
            $queryString = http_build_query($data);
            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Content-Type' => 'application/json',
            ])->put(config('constants.end-point').'/activity-api/3.0/bookings',$data);
            // echo json_encode(config('constants.end-point') . '/activity-api/3.0/bookings?'.$queryString);exit;
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

    public function PreConfirmBoooking(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'language' => 'required',
                'holder'  => 'required|json',
                'activities'   => 'required|json',
                'clientReference' => 'required',
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
                'clientReference' => $request->clientReference,
                'language' => $request->language,
            ];
            // echo json_encode($data);exit;
            $queryString = http_build_query($data);
            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Content-Type' => 'application/json',
            ])->put(config('constants.end-point') .'/activity-api/3.0/bookings/preconfirm',$data);
            // echo json_encode(config('constants.end-point') . '/activity-api/3.0/bookings?'.$queryString);exit;
            $status = $response->status();
            if ($status === 200) {
                $responseData = $response->json();
                // echo json_encode($status);exit;

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
    
    public function ReConfirmBooking(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'language' => 'required',
                'reference' => 'required',
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
                'reference' => $request->reference,
                'language' => $request->language,
            ];
            // echo json_encode($data);exit;
            $queryString = http_build_query($data);
            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Content-Type' => 'application/json',
            ])->put(config('constants.end-point') .'/activity-api/3.0/bookings/reconfirm',$data);
            // echo json_encode(config('constants.end-point') . '/activity-api/3.0/bookings?'.$queryString);exit;
            $status = $response->status();
            if ($status === 200) {
                $responseData = $response->json();
                // echo json_encode($status);exit;

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

    public function BookingList(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'language' => 'required',
                'filterType' => ['required', Rule::in(['CHECKIN','CREATION','CANCELLATION'])],
                'start' => 'required|date',
                'end' => 'required|date',
                'includedCancelled' => ['required','string'],
                'holder' => ['array'],
                'itemsPerPage' => ['integer'],
                'page' => ['integer'],
                
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
                'filterType' => $request->filterType,
                'start' => $request->start,
                'end' => $request->end,
                'includedCancelled' => $request->includedCancelled,
                'holder' => $request->holder ? json_decode($request->holder, TRUE) : null,
                'itemsPerPage' => $request->itemsPerPage ? $request->itemsPerPage : null,
                'page' => $request->page ? $request->page : '1',
            ];
            // echo json_encode($data);exit;
            $queryString = http_build_query($data);
            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point') .'/activity-api/3.0/bookings/'.$request->language.'?'.$queryString);
            // echo json_encode(config('constants.end-point') . '/activity-api/3.0/bookings?'.$queryString);exit;
            $status = $response->status();
            if ($status === 200) {
                $responseData = $response->json();
                // echo json_encode($status);exit;

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
    
    public function BookingDetails(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'language' => 'required',
                'bookingReference' => 'required',
                
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }
            // echo json_encode($request->all());exit;
            
                $language =$request->language;
                $bookingReference = $request->bookingReference;
                
        
            // echo json_encode($data);exit;
            
            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point') .'/activity-api/3.0/bookings/'.$language.'/'.$bookingReference);
            // echo json_encode(config('constants.end-point') .'/activity-api/3.0/bookings/'.$language.'/'.$bookingReference);exit;
            $status = $response->status();
            if ($status === 200) {
                $responseData = $response->json();
                // echo json_encode($status);exit;

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

    public function BookingDetailOptions(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'language' => 'required',
                'customerReference' => 'required',
                'holderName' => 'required',
                'holderSurname' => 'required',
                'from' => 'required|date',
                'to' => 'required|date',
                
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }
            // echo json_encode($request->all());exit;
            
                $language =$request->language;
                $customerReference = $request->customerReference;
                $holderName = $request->holderName;
                $holderSurname = $request->holderSurname;
                $from = $request->from;
                $to = $request->to;
                
        
            // echo json_encode($from);exit;
            
            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
            ])->get(config('constants.end-point') .'/activity-api/3.0/bookings/'.$language.'/'.$customerReference.'/'.$holderName.'/'.$holderSurname.'/'.$from.'/'.$to);
            // echo json_encode(config('constants.end-point') .'/activity-api/3.0/bookings/'.$language.'/'.$customerReference.'/'.$holderName.'/'.$holderSurname.'/'.$from.'/'.$to);exit;
            $status = $response->status();
            if ($status === 200) {
                $responseData = $response->json();
                // echo json_encode($status);exit;

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

    public function ConfirmedBookingListFilter(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'language' => 'required',
                'filterType' => ['required', Rule::in(['CHECKIN','CREATION','CANCELLATION'])],
                'includedCancelled' => 'required',
                'start' => 'required|date',
                'end' => 'required|date',
                
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }
            // echo json_encode($request->all());exit;
            
                $language =$request->language;
                $data = [
                    'filterType' => $request->filterType,
                    'includedCancelled' => $request->includedCancelled,
                    'start' => $request->start,
                    'end' => $request->end,
                ];
                $queryString = http_build_query($data);

                // $filterType = $request->filterType;
                // $includedCancelled = $request->includedCancelled;
                // $start = $request->start;
                // $end = $request->end;
                
        
            // echo json_encode($from);exit;
            
            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
            ])->get(config('constants.end-point') .'/activity-api/3.0/bookings/'.$language.'?'.$queryString);
            // echo json_encode(config('constants.end-point') .'/activity-api/3.0/bookings/'.$language.'/'.$customerReference.'/'.$holderName.'/'.$holderSurname.'/'.$from.'/'.$to);exit;
            $status = $response->status();
            if ($status === 200) {
                $responseData = $response->json();
                // echo json_encode($status);exit;

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

    public function CancelBooking(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'language' => 'required',
                'bookingReference' => 'required',
                'cancellationFlag' => 'required',Rule::in(['SIMULATION','CANCELLATION']),
                
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }
            // echo json_encode($request->all());exit;
            
                $language =$request->language;
                $bookingReference = $request->bookingReference;
                $cancellationFlag = $request->cancellationFlag;
                
                
        
            // echo json_encode($from);exit;
            
            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
            ])->delete(config('constants.end-point') .'/activity-api/3.0/bookings/'.$language.'/'.$bookingReference.'?cancellationFlag='.$cancellationFlag);
            // echo json_encode(config('constants.end-point') .'/activity-api/3.0/bookings/'.$language.'/'.$customerReference.'/'.$holderName.'/'.$holderSurname.'/'.$from.'/'.$to);exit;
            $status = $response->status();
            if ($status === 200) {
                $responseData = $response->json();
                // echo json_encode($status);exit;

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
