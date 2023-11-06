<?php

namespace App\Http\Controllers\api\hotels;

use App\Http\Controllers\Controller;
use App\Models\Markup;
use App\Models\MasterHotel_1;
use App\Models\MasterHotel_2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function calculateSignature() {
        // Retrieve the public key, private key, and UTC date from your Laravel environment or configuration.
        $publicKey = config('constants.hotel.Api-key');
        $privateKey = config('constants.hotel.secret');
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

    public function hotels(Request $request) {

        $validator = Validator::make($request->all(), [
            'stay'        => 'required|json',
            'occupancies' => 'required|json',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
            
            $data = [
                "stay" => json_decode($request->stay, TRUE),
                "occupancies" => json_decode($request->occupancies, TRUE),
            ];        
    
            $hotel = $request->hotel ? $request->hotel : "";
            if (!empty($hotel) && isset($hotel)) {
                $data['hotels']['hotel'] = explode(',', $request->hotel);
            }

            $geolocation = $request->geolocation ? $request->geolocation : "";
            if (!empty($geolocation) && isset($geolocation)) {
                $data['geolocation']= json_decode($request->geolocation, TRUE);
            }

            $rooms = $request->rooms ? $request->rooms : "";
            if (!empty($rooms) && isset($rooms)) {
                $data['rooms']= json_decode($request->rooms, TRUE);
            }

            $filter = $request->filter ? $request->filter : "";
            if (!empty($filter) && isset($filter)) {
                $data['filter']= json_decode($request->filter, TRUE);
            }

            $boards = $request->boards ? $request->boards : "";
            if (!empty($boards) && isset($boards)) {
                $data['boards']= json_decode($request->boards, TRUE);
            }
            
            $dailyRate = $request->dailyRate ? $request->dailyRate : "";
            if (!empty($dailyRate) && isset($dailyRate)) {
                $data['dailyRate']= $request->dailyRate;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $keywords = $request->keywords ? $request->keywords : "";
            if (!empty($keywords) && isset($keywords)) {
                $data['keywords']= json_decode($request->keywords, TRUE);
            }

            $review = $request->review ? $request->review : "";
            if (!empty($review) && isset($review)) {
                $data['reviews']= json_decode($request->review, TRUE);
            }

            $accommodations = $request->accommodations ? $request->accommodations : "";
            if (!empty($accommodations) && isset($accommodations)) {
                $data['accommodations']= explode(',', $request->accommodations);
            }

            $inclusions = $request->inclusions ? $request->inclusions : "";
            if (!empty($inclusions) && isset($inclusions)) {
                $data['inclusions']= explode(',', $request->inclusions);
            }
            
            $destination = $request->destination ? $request->destination : "";
            if (!empty($destination) && isset($destination)) {
                $data['destination'] = json_decode($request->destination, TRUE);
            }
            
            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->post(config('constants.end-point').'/hotel-api/1.0/hotels', $data);
            
            $responseData = $response->json();
            
            $status = $response->status();

            if ($status == "200" && isset($responseData['hotels']['hotels'])) {
                
                $markup = Markup::where('status', 1)->first()->value('markup');
                $hotels = $responseData['hotels']['hotels'];

                foreach ($hotels as &$hotel) {
                    $minRate = $hotel['minRate'];
                    $hotel['minRate'] = $minRate + ($minRate * $markup / 100);
                    $maxRate = $hotel['maxRate'];
                    $hotel['maxRate'] = $maxRate + ($maxRate * $markup / 100);

                    // if (isset($hotel['rooms'])) {
                    //     unset($hotel['rooms']);
                    // }
                    
                    $hotelCode = $hotel['code'];
                
                    $hotelDetails = MasterHotel_1::where('code', $hotelCode)->first();
                    if (!$hotelDetails) {
                        $hotelDetails = MasterHotel_2::where('code', $hotelCode)->first();
                    }
                
                    $hotel['images'] = $hotelDetails ? explode(', ', $hotelDetails->images) : [];
                    $hotel['facilities'] = $hotelDetails ? explode(', ', $hotelDetails->facilities) : [];
                    $hotel['S2C'] = $hotelDetails ? $hotelDetails->S2C : null;
                    $hotel['ranking'] = $hotelDetails ? $hotelDetails->ranking : null;
                }
                
                $responseData['hotels']['hotels'] = $hotels;
                
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'total'     => $responseData['hotels']['total'],
                    'data'      => $responseData['hotels']['hotels']
                ], $status);
                
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                    'data'      => []
                ], $status);
            }
            
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }
    
    // public function hotels(Request $request) {

    //     $validator = Validator::make($request->all(), [
    //         'stay'        => 'required|json',
    //         'occupancies' => 'required|json',
    //     ]);

    //     if($validator->fails()){
    //         return response()->json([
    //             'status'    => 'failed',
    //             'message'   => trans('msg.validation'),
    //             'errors'    => $validator->errors()
    //         ],400);
    //     }

    //     try {
            
    //         $data = [
    //             "stay" => json_decode($request->stay, TRUE),
    //             "occupancies" => json_decode($request->occupancies, TRUE),
    //         ];        
    
    //         $hotel = $request->hotel ? $request->hotel : "";
    //         if (!empty($hotel) && isset($hotel)) {
    //             $data['hotels']['hotel'] = explode(',', $request->hotel);
    //         }

    //         $geolocation = $request->geolocation ? $request->geolocation : "";
    //         if (!empty($geolocation) && isset($geolocation)) {
    //             $data['geolocation']= json_decode($request->geolocation, TRUE);
    //         }

    //         $rooms = $request->rooms ? $request->rooms : "";
    //         if (!empty($rooms) && isset($rooms)) {
    //             $data['rooms']= json_decode($request->rooms, TRUE);
    //         }

    //         $filter = $request->filter ? $request->filter : "";
    //         if (!empty($filter) && isset($filter)) {
    //             $data['filter']= json_decode($request->filter, TRUE);
    //         }

    //         $boards = $request->boards ? $request->boards : "";
    //         if (!empty($boards) && isset($boards)) {
    //             $data['boards']= json_decode($request->boards, TRUE);
    //         }
            
    //         $dailyRate = $request->dailyRate ? $request->dailyRate : "";
    //         if (!empty($dailyRate) && isset($dailyRate)) {
    //             $data['dailyRate']= $request->dailyRate;
    //         }

    //         $language = $request->language ? $request->language : "";
    //         if (!empty($language) && isset($language)) {
    //             $data['language']= $request->language;
    //         }

    //         $keywords = $request->keywords ? $request->keywords : "";
    //         if (!empty($keywords) && isset($keywords)) {
    //             $data['keywords']= json_decode($request->keywords, TRUE);
    //         }

    //         $review = $request->review ? $request->review : "";
    //         if (!empty($review) && isset($review)) {
    //             $data['reviews']= json_decode($request->review, TRUE);
    //         }

    //         $accommodations = $request->accommodations ? $request->accommodations : "";
    //         if (!empty($accommodations) && isset($accommodations)) {
    //             $data['accommodations']= explode(',', $request->accommodations);
    //         }

    //         $inclusions = $request->inclusions ? $request->inclusions : "";
    //         if (!empty($inclusions) && isset($inclusions)) {
    //             $data['inclusions']= explode(',', $request->inclusions);
    //         }
            
    //         $destination = $request->destination ? $request->destination : "";
    //         if (!empty($destination) && isset($destination)) {
    //             $data['destination'] = json_decode($request->destination, TRUE);
    //         }
            
    //         $Signature = self::calculateSignature();

    //         $response = Http::withHeaders([
    //             'Api-key' => config('constants.hotel.Api-key'),
    //             'X-Signature' => $Signature,
    //             'Accept' => 'application/json',
    //             'Accept-Encoding' => 'gzip',
    //             'Content-Type' => 'application/json',
    //         ])->post(config('constants.end-point').'/hotel-api/1.0/hotels', $data);
            
    //         $responseData = $response->json();
            
    //         $status = $response->status();

    //         if ($status == "200") {
    //             $hotels = $responseData['hotels']['hotels'];
    //             $hotelDetailsArray = [];

    //             foreach ($hotels as $hotel) {
    //                 if (isset($hotel['rooms'])) {
    //                     unset($hotel['rooms']);
    //                 }
                    
    //                 $hotelCode = $hotel['code'];
    //                 $hotelDetails = $this->hotelDetails($hotelCode);
    //                 $hotel['images'] = $hotelDetails['images']; 
    //                 $hotel['facilities'] = $hotelDetails['facilities'];
    //                 $hotel['S2C'] = $hotelDetails['S2C'];
    //                 $hotel['ranking'] = $hotelDetails['ranking'];
    //                 $hotelDetailsArray[] = $hotel; 
    //             }

    //             $responseData['hotels']['hotels'] = $hotelDetailsArray;

    //             return response()->json([
    //                 'status'    => 'success',
    //                 'message'   => trans('msg.list.success'),
    //                 'data'      => $responseData['hotels']['hotels']
    //             ],$status);
    //         } else {
    //             return response()->json([
    //                 'status'    => 'failed',
    //                 'message'   => trans('msg.list.failed'),
    //                 'data'      => $responseData
    //             ],$status);
    //         }
            
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'status'    => 'failed',
    //             'message'   => trans('msg.error'),
    //             'error'     => $e->getMessage()
    //         ],500);
    //     }
    // }

    function hotelDetails($hotelCode) {
        $Signature = self::calculateSignature();
        $response = Http::withHeaders([
            'Api-key' => config('constants.hotel.Api-key'),
            'X-Signature' => $Signature,
            'Accept' => 'application/json',
            'Accept-Encoding' => 'gzip',
            'Content-Type' => 'application/json',
        ])->get(config('constants.end-point').'/hotel-content-api/1.0/hotels/'.$hotelCode.'/details');   
        
        $responseData = $response->json();

        $status = $response->status();

        if ($status == "200") {
            $images = isset($responseData['hotel']['images']) ? $responseData['hotel']['images'] : [];
            $facilities = isset($responseData['hotel']['facilities']) ? $responseData['hotel']['facilities'] : [];
            $S2C = isset($responseData['hotel']['S2C']) ? $responseData['hotel']['S2C'] : [];
            $ranking = isset($responseData['hotel']['ranking']) ? $responseData['hotel']['ranking'] : [];
            $falilityData = [];
            $facilityImages = [];

            foreach($facilities as $facility) {
                $falilityData[] = $facility['description']['content'];
            }

            $limitedImages = array_slice($images, 0, 8);

            foreach($limitedImages as $limitedImage) {
                $facilityImages[] = 'https://photos.hotelbeds.com/giata/'.$limitedImage['path'];
            }

            $data = [
                'images' => $facilityImages,
                'facilities' => $falilityData,
                'S2C' =>  $S2C,
                'ranking' => $ranking
            ];
        } else {
           $data = [
                'images' => [],
                'facilities' => [],
                'S2C' =>  '',
                'ranking' => ''
           ];
        }
       

        return $data;
    }

    public function checkrates(Request $request) {

        $validator = Validator::make($request->all(), [
            'rooms'  => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
            
            $data = [
                "rooms" => json_decode($request->rooms, TRUE),
            ]; 

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }
            
            $upselling = $request->upselling ? $request->upselling : "";
            if (!empty($upselling) && isset($upselling)) {
                $data['upselling']= $request->upselling;
            }

            $expandCXL = $request->expandCXL ? $request->expandCXL : "";
            if (!empty($expandCXL) && isset($expandCXL)) {
                $data['expandCXL']= $request->expandCXL;
            }

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->post(config('constants.end-point').'/hotel-api/1.0/checkrates', $data);
            
            $responseData = $response->json();
            
            $status = $response->status();

            if ($status == "200") {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'data'      => $responseData['hotel']
                ],$status);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                    'data'      => $responseData
                ],$status);
            }
            
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }

    public function bookings(Request $request) {

        $validator = Validator::make($request->all(), [
            'holder'  => 'required|json',
            'rooms'   => 'required|json',
            'clientReference' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
            
            $data = [
                "holder" => json_decode($request->holder, TRUE),
                "rooms" => json_decode($request->rooms, TRUE),
                'clientReference' => $request->clientReference,
            ];

            $paymentData = $request->paymentData ? $request->paymentData : "";
            if (!empty($paymentData) && isset($paymentData)) {
                $data['paymentData']= json_decode($request->paymentData, TRUE);
            }

            $creationUser = $request->creationUser ? $request->creationUser : "";
            if (!empty($creationUser) && isset($creationUser)) {
                $data['creationUser']= $request->creationUser;
            }

            $remark = $request->remark ? $request->remark : "";
            if (!empty($remark) && isset($remark)) {
                $data['remark']= $request->remark;
            }
            
            $voucher = $request->voucher ? $request->voucher : "";
            if (!empty($voucher) && isset($voucher)) {
                $data['voucher']= json_decode($request->voucher, TRUE);
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $tolerance = $request->tolerance ? $request->tolerance : "";
            if (!empty($tolerance) && isset($tolerance)) {
                $data['tolerance']= $request->tolerance;
            }

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->post(config('constants.secure-end-point').'/hotel-api/1.0/bookings', $data);
            
            $responseData = $response->json();
            
            $status = $response->status();

            if ($status == "200") {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.booking.success'),
                    'data'      => $responseData
                ],$status);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.booking.failed'),
                    'data'      => $responseData
                ],$status);
            }
            
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }

    public function bookingList(Request $request) {

        $validator = Validator::make($request->all(), [
            'from'  => 'required|numeric',
            'to'   => 'required|numeric',
            'start'  => 'required|date|date_format:Y-m-d',
            'end'   => 'required|date|date_format:Y-m-d',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
            
            $data = [
                "from" => $request->from,
                "to" => $request->to,
                "start" => $request->start,
                "end" => $request->end,
            ];

            $filterType = $request->filterType ? $request->filterType : "";
            if (!empty($filterType) && isset($filterType)) {
                $data['filterType']= $request->filterType;
            }

            $status = $request->status ? $request->status : "";
            if (!empty($status) && isset($status)) {
                $data['status']= $request->status;
            }

            $remark = $request->remark ? $request->remark : "";
            if (!empty($remark) && isset($remark)) {
                $data['remark']= $request->remark;
            }
            
            $clientReference = $request->clientReference ? $request->clientReference : "";
            if (!empty($clientReference) && isset($clientReference)) {
                $data['clientReference']= $request->clientReference;
            }

            $creationUser = $request->creationUser ? $request->creationUser : "";
            if (!empty($creationUser) && isset($creationUser)) {
                $data['creationUser']= $request->creationUser;
            }

            $country = $request->country ? $request->country : "";
            if (!empty($country) && isset($country)) {
                $data['country']= $request->country;
            }

            $hotel = $request->hotel ? $request->hotel : "";
            if (!empty($hotel) && isset($hotel)) {
                $data['hotel'] = $request->hotel;
            }

            $destination = $request->destination ? $request->destination : "";
            if (!empty($destination) && isset($destination)) {
                $data['destination'] = $request->destination;
            }
            
            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-api/1.0/bookings?'. $queryString);
            
            $responseData = $response->json();
            
            $status = $response->status();

            if ($status == "200") {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'data'      => $responseData
                ],$status);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                    'data'      => $responseData
                ],$status);
            }
            
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }

    public function bookingDetails(Request $request) {

        $validator = Validator::make($request->all(), [
            'bookingId'  => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
            
            $data = [];

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $bookingId = $request->bookingId;

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-api/1.0/bookings/'.$bookingId.'?', $queryString);
            
            $responseData = $response->json();
            
            $status = $response->status();

            if ($status == "200") {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.detail.success'),
                    'data'      => $responseData
                ],$status);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.detail.failed'),
                    'data'      => $responseData
                ],$status);
            }
            
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }

    public function bookingChange(Request $request) {

        $validator = Validator::make($request->all(), [
            'bookingId'  => 'required',
            'mode'       => 'required',
            'booking'    => 'required|json'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
            
            $data = [
                'mode' => $request->mode,
                'booking' => json_decode($request->booking, TRUE)
            ];

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $paymentData = $request->paymentData ? $request->paymentData : "";
            if (!empty($paymentData) && isset($paymentData)) {
                $data['paymentData']= json_decode($request->paymentData, TRUE);
            }

            $bookingId = $request->bookingId;

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->put(config('constants.secure-end-point').'/hotel-api/1.0/bookings/'.$bookingId, $data);
            
            $responseData = $response->json();
            
            $status = $response->status();

            if ($status == "200") {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.booking.success'),
                    'data'      => $responseData
                ],$status);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.booking.failed'),
                    'data'      => $responseData
                ],$status);
            }
            
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }

    public function bookingCancel(Request $request) {

        $validator = Validator::make($request->all(), [
            'bookingId'  => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
            
            $data = [];

            $cancellationFlag = $request->cancellationFlag ? $request->cancellationFlag : "";
            if (!empty($cancellationFlag) && isset($cancellationFlag)) {
                $data['cancellationFlag']= $request->cancellationFlag;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $bookingId = $request->bookingId;

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->delete(config('constants.end-point').'/hotel-api/1.0/bookings/'.$bookingId.'?'. $queryString);
            
            $responseData = $response->json();
            
            $status = $response->status();

            if ($status == "200") {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.booking-cancel.success'),
                    'data'      => $responseData
                ],$status);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.booking-cancel.failed'),
                    'data'      => $responseData
                ],$status);
            }
            
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }

    public function bookingReconfirmation(Request $request) {

        $validator = Validator::make($request->all(), [
            'from'  => 'required|numeric',
            'to'    => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors()
            ],400);
        }

        try {
            
            $data = [
                'from' => $request->from,
                'to'   => $request->to,
            ];

            $start = $request->start ? $request->start : "";
            if (!empty($start) && isset($start)) {
                $data['start']= $request->start;
            }

            $end = $request->end ? $request->end : "";
            if (!empty($end) && isset($end)) {
                $data['end']= $request->end;
            }

            $filterType = $request->filterType ? $request->filterType : "";
            if (!empty($filterType) && isset($filterType)) {
                $data['filterType']= $request->filterType;
            }

            $references = $request->references ? $request->references : "";
            if (!empty($references) && isset($references)) {
                $data['references']= explode(',', $request->references);
            }

            $clientReferences = $request->clientReferences ? $request->clientReferences : "";
            if (!empty($clientReferences) && isset($clientReferences)) {
                $data['clientReferences'] = explode(',', $request->clientReferences);
            }

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-api/1.0/reconfirmations', $data);
            
            $responseData = $response->json();
            
            $status = $response->status();

            if ($status == "200") {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'data'      => $responseData
                ],$status);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                    'data'      => $responseData
                ],$status);
            }
            
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }
}
