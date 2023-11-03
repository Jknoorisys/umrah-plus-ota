<?php

namespace App\Http\Controllers\api\hotels;

use App\Http\Controllers\Controller;
use App\Models\MasterCountry;
use App\Models\MasterCurrency;
use App\Models\MasterDestination;
use App\Models\MasterFacilities;
use App\Models\MasterHotel;
use App\Models\MasterHotel_1;
use App\Models\MasterHotels1;
use App\Models\MasterHotelsAfrica;
use App\Models\MasterHotelsAfricaImages;
use App\Models\MasterHotelsAsia;
use App\Models\MasterHotelsAsiaImages;
use App\Models\MasterHotelsAntarctica;
use App\Models\MasterHotelsAntarcticaImages;
use App\Models\MasterHotelsEurope;
use App\Models\MasterHotelsEuropeImages;
use App\Models\MasterLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    public function calculateSignature()
    {
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

    // public function hotels(Request $request) {

    //     try {
    //         $data = [];       
    
    //         $destinationCode = $request->destinationCode ? $request->destinationCode : "";
    //         if (!empty($destinationCode) && isset($destinationCode)) {
    //             $data['destinationCode'] = $request->destinationCode;
    //         }

    //         $countryCode = $request->countryCode ? $request->countryCode : "";
    //         if (!empty($countryCode) && isset($countryCode)) {
    //             $data['countryCode']= $request->countryCode;
    //         }

    //         $codes = $request->codes ? $request->codes : "";
    //         if (!empty($codes) && isset($codes)) {
    //             $data['codes']= $request->codes;
    //         }

    //         $includeHotels = $request->includeHotels ? $request->includeHotels : "";
    //         if (!empty($includeHotels) && isset($includeHotels)) {
    //             $data['includeHotels']= $request->includeHotels;
    //         }

    //         $fields = $request->fields ? $request->fields : "";
    //         if (!empty($fields) && isset($fields)) {
    //             $data['fields']= $request->fields;
    //         }

    //         $language = $request->language ? $request->language : "";
    //         if (!empty($language) && isset($language)) {
    //             $data['language']= $request->language;
    //         }

    //         $from = $request->from ? $request->from : "";
    //         if (!empty($from) && isset($from)) {
    //             $data['from']= $request->from;
    //         }

    //         $to = $request->to ? $request->to : "";
    //         if (!empty($to) && isset($to)) {
    //             $data['to']= $request->to;
    //         }

    //         $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
    //         if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
    //             $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
    //         }

    //         $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
    //         if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
    //             $data['lastUpdateTime']= $request->lastUpdateTime;
    //         }

    //         $PMSRoomCode = $request->PMSRoomCode ? $request->PMSRoomCode : "";
    //         if (!empty($PMSRoomCode) && isset($PMSRoomCode)) {
    //             $data['PMSRoomCode']= $request->PMSRoomCode;
    //         }
            
    //         $queryString = http_build_query($data);
        
    //         $Signature = self::calculateSignature();
        
    //         $response = Http::withHeaders([
    //             'Api-key' => config('constants.hotel.Api-key'),
    //             'X-Signature' => $Signature,
    //             'Accept' => 'application/json',
    //             'Accept-Encoding' => 'gzip',
    //             'Content-Type' => 'application/json',
    //         ])->get(config('constants.end-point') . '/hotel-content-api/1.0/hotels?' . $queryString);
        
    //         $responseData = $response->json();
        
    //         $status = $response->status();

    //         if ($status == "200") {
    //             // $hotels = $responseData['hotels'];
    //             // $codes = [];
    //             foreach ($hotels as $hotel) {
    //                 $hotelCode = $hotel['code'];
    //                 $codes[] = $hotelCode;

    //                 // $hotelDetails = $this->hotelData($hotelCode);
    //                 // $images = $hotelDetails['images']; 
    //                 // $facilities = $hotelDetails['facilities'];
    //                 // $S2C = $hotelDetails['S2C'];
    //                 // $ranking = $hotelDetails['ranking'];
                    
    //                 $images = isset($hotel['images']) ? $hotel['images'] : [];
    //                 $facilities = isset($hotel['facilities']) ? $hotel['facilities'] : [];
    //                 $S2C = isset($hotel['S2C']) ? $hotel['S2C'] : '';
    //                 $ranking = isset($hotel['ranking']) ? $hotel['ranking'] : '';

    //                 if ($facilities) {
    //                     $hotelFacilities = [];
    //                     foreach ($facilities as $facility) {
    //                         $facilityDetails = MasterFacilities::where('code', '=', $facility['facilityCode'])->where('group_code', '=', $facility['facilityGroupCode'])->first();
    //                         if ($facilityDetails) {
    //                             $hotelFacilities[] = $facilityDetails->facility; 
    //                         }
    //                     }
    //                 }

    //                 $hotelData = [
    //                     'code' => $hotelCode,
    //                     'hotel' => $hotel['name']['content'],
    //                     'facilities' => $hotelFacilities ? implode(', ', $hotelFacilities) : '',
    //                     'S2C' => $S2C,
    //                     'ranking' => $ranking
    //                 ];

    //                 MasterHotelsEurope::create($hotelData);
                    
    //                 if ($images) {
                        
    //                     foreach ($images as $image) {
    //                         // $imageData = [
    //                         //     'hotel_code' => $hotelCode,
    //                         //     'image' => $image
    //                         // ];

    //                         $imageData = [
    //                             'hotel_code' => $hotelCode,
    //                             'image' => 'https://photos.hotelbeds.com/giata/'.$image['path']
    //                         ];

    //                         // echo json_encode($imageData);

    //                         MasterHotelsEuropeImages::create($imageData);
    //                     }   
    //                 }
    //             }

    //             // $count = MasterHotelsEurope::whereIn('code', $codes)->count();
    //             // return $count;exit;
                
    //             return response()->json([
    //                 'status'    => 'success',
    //                 'message'   => trans('msg.list.success'),
    //                 'total'     => $responseData['total'],
    //                 // 'data'      => $responseData['hotels']
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

    public function hotels(Request $request) {
        ini_set('max_execution_time', 2000);

        try {
            $data = [];       
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields']= $request->fields;
            }

            $data['from'] = 1;
            $data['to'] = 100;
            
            for ($i = 0; $i < 50; $i++) {
            
                $queryString = http_build_query($data);
            
                $Signature = self::calculateSignature();
            
                $response = Http::withHeaders([
                    'Api-key' => config('constants.hotel.Api-key'),
                    'X-Signature' => $Signature,
                    'Accept' => 'application/json',
                    'Accept-Encoding' => 'gzip',
                    'Content-Type' => 'application/json',
                ])->get(config('constants.end-point') . '/hotel-content-api/1.0/hotels?' . $queryString);
            
                $responseData = $response->json();
            
                $status = $response->status();

                if ($status == "200") {
                    $hotels = $responseData['hotels'];
                    foreach ($hotels as $hotel) {
                        $hotelCode = $hotel['code'];
                        
                        $images = isset($hotel['images']) ? $hotel['images'] : [];
                        $paths = collect($images)->pluck('path')->toArray();
                        $commaSeparatedValues = implode(', ', $paths);

                        $S2C = isset($hotel['S2C']) ? $hotel['S2C'] : '';
                        $ranking = isset($hotel['ranking']) ? $hotel['ranking'] : '';
                        $facilities = isset($hotel['facilities']) ? $hotel['facilities'] : [];

                        if ($facilities) {
                            $hotelFacilities = [];
                            foreach ($facilities as $facility) {
                                $facilityDetails = MasterFacilities::where('code', '=', $facility['facilityCode'])->where('group_code', '=', $facility['facilityGroupCode'])->first();
                                if ($facilityDetails) {
                                    $hotelFacilities[] = $facilityDetails->facility; 
                                }
                            }
                        }

                        $hotelData = [
                            'code' => $hotelCode,
                            'hotel' => $hotel['name']['content'],
                            'facilities' => $hotelFacilities ? implode(', ', $hotelFacilities) : '',
                            'S2C' => $S2C,
                            'images' => $commaSeparatedValues,
                            'ranking' => $ranking
                        ];

                        MasterHotel_1::create($hotelData);
                    }
                }

                $data['from'] = $data['to'] + 1;
                $data['to'] += 100;

                sleep(3);
            }

            return 'Successfully Done';
            
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }

    public function hotels_aaisha(Request $request) {
        ini_set('max_execution_time', 2000);

        try {
            $data = [];       
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields']= $request->fields;
            }

            $data['from'] = 1;
            $data['to'] = 100;
            
            for ($i = 0; $i < 50; $i++) {
            
                $queryString = http_build_query($data);
            
                $Signature = self::calculateSignature();
            
                $response = Http::withHeaders([
                    'Api-key' => config('constants.hotel.Api-key'),
                    'X-Signature' => $Signature,
                    'Accept' => 'application/json',
                    'Accept-Encoding' => 'gzip',
                    'Content-Type' => 'application/json',
                ])->get(config('constants.end-point') . '/hotel-content-api/1.0/hotels?' . $queryString);
            
                $responseData = $response->json();
            
                $status = $response->status();

                if ($status == "200") {
                    $hotels = $responseData['hotels'];
                    foreach ($hotels as $hotel) {
                        $hotelCode = $hotel['code'];
                        
                        $images = isset($hotel['images']) ? $hotel['images'] : [];
                        $paths = collect($images)->pluck('path')->toArray();
                        $commaSeparatedValues = implode(', ', $paths);

                        $S2C = isset($hotel['S2C']) ? $hotel['S2C'] : '';
                        $ranking = isset($hotel['ranking']) ? $hotel['ranking'] : '';
                        $facilities = isset($hotel['facilities']) ? $hotel['facilities'] : [];

                        if ($facilities) {
                            $hotelFacilities = [];
                            foreach ($facilities as $facility) {
                                $facilityDetails = MasterFacilities::where('code', '=', $facility['facilityCode'])->where('group_code', '=', $facility['facilityGroupCode'])->first();
                                if ($facilityDetails) {
                                    $hotelFacilities[] = $facilityDetails->facility; 
                                }
                            }
                        }

                        $hotelData = [
                            'code' => $hotelCode,
                            'hotel' => $hotel['name']['content'],
                            'facilities' => $hotelFacilities ? implode(', ', $hotelFacilities) : '',
                            'S2C' => $S2C,
                            'images' => $commaSeparatedValues,
                            'ranking' => $ranking
                        ];

                        MasterHotel_1::create($hotelData);
                    }
                }

                $data['from'] = $data['to'] + 1;
                $data['to'] += 100;

                sleep(3);
            }

            return 'Successfully Done';
            
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }

    function hotelData($hotelCode) {
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
                'S2C' =>  $S2C ? $S2C : '',
                'ranking' => $ranking ? $ranking : ''
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

    public function hotelDetails(Request $request) {

        $validator = Validator::make($request->all(), [
            'hotelCodes'  => 'required',
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

            $hotelCodes = $request->hotelCodes;

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }
            
            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/hotels/'.$hotelCodes.'/details?'. $queryString);
            
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

    public function countries(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/locations/countries?'. $queryString);
            
            $responseData = $response->json();

            // Create Master Country Data
            // $countries = $responseData['countries'];
            // foreach ($countries as $country) {
            //     $countryData = [
            //         'code' => $country['code'],
            //         'isoCode' => $country['isoCode'],
            //         'country' => $country['description']['content'],
            //     ];
            //     $country = MasterCountry::create($countryData);
            // }
            
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
    
    public function destinations(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $countryCodes = $request->countryCodes ? $request->countryCodes : "";
            if (!empty($countryCodes) && isset($countryCodes)) {
                $data['countryCodes']= $request->countryCodes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/locations/destinations?'. $queryString);
            
            $responseData = $response->json();
            
            $status = $response->status();

            // Create Master Country Data
            // $destinations = $responseData['destinations'];
            // foreach ($destinations as $destination) {
            //     $destinationData = [
            //         'code' => $destination['code'],
            //         'destination' => $destination['name']['content'],
            //     ];
            //     $destination = MasterDestination::create($destinationData);
            // }

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

    public function accommodations(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/accommodations?'. $queryString);
            
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

    public function boards(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/boards?'. $queryString);
            
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

    public function categories(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/categories?'. $queryString);
            
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

    public function chains(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/chains?'. $queryString);
            
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
    
    public function currencies(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/currencies?'. $queryString);
            
            $responseData = $response->json();
            
            $status = $response->status();

            // Create Master Currency Data
            // $currencies = $responseData['currencies'];
            // foreach ($currencies as $currency) {
            //     $currencyData = [
            //         'code' => $currency['code'],
            //         'currency' => $currency['description']['content'],
            //     ];
            //     $currency = MasterCurrency::create($currencyData);
            // }

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

    public function facilities(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/facilities?', $queryString);
            
            $responseData = $response->json();
            
            $status = $response->status();

            if ($status == "200") {
                $facilities = $responseData['facilities'];
                // foreach ($facilities as $facility) {
                //     $data = [
                //         'code' => $facility['code'],
                //         'group_code' => $facility['facilityGroupCode'],
                //         'facility' => $facility['description'] ?  $facility['description']['content'] : ''
                //     ];
                    
                //     MasterFacilities::create($data);
                // }
                
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'total'     => $responseData['total'],
                    'data'      => $facilities
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

    public function facilitygroups(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/facilitygroups?'. $queryString);
            
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

    public function facilitytypologies(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/facilitytypologies?', $queryString);
            
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

    public function issues(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/issues?', $queryString);
            
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

    public function languages(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/languages?', $queryString);
            
            $responseData = $response->json();
            
            $status = $response->status();

            // Create Master Language Data
            // $languages = $responseData['languages'];
            // foreach ($languages as $language) {
            //     $languageData = [
            //         'code' => $language['code'],
            //         'language' => $language['description']['content'],
            //     ];
            //     $language = MasterLanguage::create($languageData);
            // }

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

    public function promotions(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/promotions?'. $queryString);
            
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

    public function rooms(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/rooms?'. $queryString);
            
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

    public function segments(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/segments?'. $queryString);
            
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

    public function terminals(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/terminals?'. $queryString);
            
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

    public function imagetypes(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/imagetypes?'. $queryString);
            
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

    public function groupcategories(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/groupcategories?'. $queryString);
            
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

    public function ratecomments(Request $request) {

        try {
            
            $data = [];        
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/ratecomments?'. $queryString);
            
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

    public function ratecommentdetails(Request $request) {
        $validator = Validator::make($request->all(), [
            'date'  => 'required|date|date_format:Y-m-d',
            'code'  => 'required'
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
    
            $fields = $request->fields ? $request->fields : "";
            if (!empty($fields) && isset($fields)) {
                $data['fields'] = $request->fields;
            }

            $date = $request->date ? $request->date : "";
            if (!empty($date) && isset($date)) {
                $data['date']= $request->date;
            }

            $code = $request->code ? $request->code : "";
            if (!empty($code) && isset($code)) {
                $data['code']= $request->code;
            }

            $language = $request->language ? $request->language : "";
            if (!empty($language) && isset($language)) {
                $data['language']= $request->language;
            }

            $from = $request->from ? $request->from : "";
            if (!empty($from) && isset($from)) {
                $data['from']= $request->from;
            }

            $to = $request->to ? $request->to : "";
            if (!empty($to) && isset($to)) {
                $data['to']= $request->to;
            }

            $useSecondaryLanguage = $request->useSecondaryLanguage ? $request->useSecondaryLanguage : "";
            if (!empty($useSecondaryLanguage) && isset($useSecondaryLanguage)) {
                $data['useSecondaryLanguage']= $request->useSecondaryLanguage;
            }

            $lastUpdateTime = $request->lastUpdateTime ? $request->lastUpdateTime : "";
            if (!empty($lastUpdateTime) && isset($lastUpdateTime)) {
                $data['lastUpdateTime']= $request->lastUpdateTime;
            }

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.hotel.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/hotel-content-api/1.0/types/ratecommentdetails?'. $queryString);
            
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
