<?php

namespace App\Http\Controllers\api\Transfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use App\Models\Markup;

class BookingController extends Controller
{
    public function calculateSignature()
    {
        // Retrieve the public key, private key, and UTC date from your Laravel environment or configuration.
        $publicKey = config('constants.transfer.Api-key');
        $privateKey = config('constants.transfer.secret');
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

    
    public function availability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required', 'string'],
            'fromType'   => ['required'],
            'fromCode'   => ['required'],
            'toType'   => ['required'],
            'toCode'   => ['required'],
            'outbound'   => ['required', 'string'],
            'inbound'   => ['string'],
            'adults'   => ['required', 'numeric'],
            'children'   => ['required', 'numeric'],
            'infants'   => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status'    => 'failed',
                    'errors'    =>  $validator->errors(),
                    'message'   =>  trans('msg.validation'),
                ],
                400
            );
        }


        try {

            $data = [];


            $data['fromType'] = $request->fromType;



            $data['language'] = $request->language;



            $data['fromCode'] = $request->fromCode;



            $data['toType'] = $request->toType;



            $data['toCode'] = $request->toCode;



            $data['outbound'] = $request->outbound;


            $inbound = $request->inbound;


            $adults = $request->adults;


            $children = $request->children;

            $infants = $request->infants;

            $queryString = http_build_query($data);

            $Signature = self::calculateSignature();
            if (!empty($inbound)) {
                $response = Http::withHeaders([
                    'Api-key' => config('constants.transfer.Api-key'),
                    'X-Signature' => $Signature,
                    'Accept' => 'application/json',
                    'Accept-Encoding' => 'gzip',
                    'Content-Type' => 'application/json',
                ])->get(config('constants.end-point') . '/transfer-api/1.0/availability/' . $data['language'] . '/from/' . $data['fromType'] . '/' . $data['fromCode'] . '/to/' . $data['toType'] . '/' . $data['toCode'] . '/' . $data['outbound'] . '/' . $inbound . '/' . $adults . '/' . $children . '/' . $infants);
                $responseData = $response->json();
                $status = $response->status();
                    // echo json_encode($status);exit;
                if ($status === 200 && isset($responseData['services'])) {
                    $markup = Markup::where('service','=','transfer')->first()->value('markup');
                
                    $services = $responseData['services'];
                
                    foreach ($services as &$service) {
                        $price = $service['price']['totalAmount'];
                        $service['price']['totalAmount'] = $price + ($price * $markup / 100);
                    }
                
                    return response()->json([
                        'status'    => 'success',
                        'message'   => trans('msg.list.success'),
                        'data'      => $services  // Return all services with marked-up prices
                    ], $status);
                } elseif ($status === 204) {
                    // Handle HTTP 204 (No Content) differently
                    $responseArray = [
                        'status'    => 'success',
                        'message'   => trans('msg.list.no_content'),
                        'data'      => [],  // You may choose to return an empty array or omit 'data'

                    ];
                    echo json_encode($responseArray);
                    exit;
                
                
                } else {
                    return response()->json([
                        'status'    => 'failed',
                        'message'   => trans('msg.list.failed'),
                        'data'      => $responseData
                    ], $status);
                }
            } else {
                $response = Http::withHeaders([
                    'Api-key' => config('constants.transfer.Api-key'),
                    'X-Signature' => $Signature,
                    'Accept' => 'application/json',
                    'Accept-Encoding' => 'gzip',
                    'Content-Type' => 'application/json',
                ])->get(config('constants.end-point') . '/transfer-api/1.0/availability/' . $data['language'] . '/from/' . $data['fromType'] . '/' . $data['fromCode'] . '/to/' . $data['toType'] . '/' . $data['toCode'] . '/' . $data['outbound'] . '/' . $adults . '/' . $children . '/' . $infants);
                $responseData = $response->json();

                $status = $response->status();
                if ($status === 200 && isset($responseData['services'])) {
                    $markup = Markup::where('service','=','transfer')->first()->value('markup');
                
                    $services = $responseData['services'];
                
                    foreach ($services as &$service) {
                        $price = $service['price']['totalAmount'];
                        $service['price']['totalAmount'] = $price + ($price * $markup / 100);
                    }
                
                    return response()->json([
                        'status'    => 'success',
                        'message'   => trans('msg.list.success'),
                        'data'      => $services  // Return all services with marked-up prices
                    ], $status);
                } elseif ($status === 204) {
                    // Handle HTTP 204 (No Content) differently
                    $responseArray = [
                        'status'    => 'success',
                        'message'   => trans('msg.list.no_content'),
                        'data'      => [],  // You may choose to return an empty array or omit 'data'

                    ];
                    echo json_encode($responseArray);
                    exit;
                
                
                } else {
                    return response()->json([
                        'status'    => 'failed',
                        'message'   => trans('msg.list.failed'),
                        'data'      => $responseData
                    ], $status);
                }
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ], 500);
        }
    }

    public function AvailableRoutes(Request $request)
    {
        // Define validation rules for the request body
        $validator = Validator::make($request->all(), [
            'language' => ['required', 'string'],
            'allowPartialResults' => ['boolean'],
            'adults' => ['required', 'numeric'],
            'children' => ['required', 'numeric'],
            'infants' => ['required', 'numeric'],
            'routes' => ['required', 'array'],
            'routes.*.id' => ['required', 'string'],
            'routes.*.dateTime' => ['required', 'date'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'errors' => $validator->errors(),
                'message' => trans('msg.validation'),
            ], 400);
        }

        try {
            $data = $request->only(['vehicle', 'type', 'category']);
            $language = $request->language;
            $adults = $request->adults;
            $infants = $request->infants;
            $children = $request->children;
            $routes = $request->input('routes');
            $allowPartialResults = $request->allowPartialResults;
            $Signature = self::calculateSignature();
            $queryString = http_build_query($data);
            // echo json_encode($allowPartialResults);exit;

            if(!empty($allowPartialResults))
            {
                // echo "Hiii";exit;
                $response = Http::withHeaders([
                    'Api-key' => config('constants.transfer.Api-key'),
                    'X-Signature' => $Signature,
                    'Accept' => 'application/json',
                    'Accept-Encoding' => 'gzip',
                    'Content-Type' => 'application/json',
                ])->post(config('constants.end-point').'/transfer-api/1.0/availability/routes/'.$language.'/'.$adults.'/'.$children.'/'.$infants.'?allowPartialResults='.'true&'.$queryString);
                // echo json_encode(config('constants.end-point').'/transfer-api/1.0/availability/routes/'.$language.'/'.$adults.'/'.$children.'/'.$infants.'?allowPartialResults='.'true&'.$queryString);exit;
                $responseData = $response->json();
                // echo json_encode($response);
                // exit;
                $status = $response->status();
                // echo json_encode("Hello");exit;
        
                // Parse and set global variables from the response
                if (isset($responseData['routes'][0]['services'][0]['rateKey'])) {
                    Config::set('app.test_transfer_ratekey', $responseData['routes'][0]['services'][0]['rateKey']);
                }
        
                if (isset($responseData['routes'][2]['services'][0]['rateKey'])) {
                    Config::set('app.test_transfer_ratekey2', $responseData['routes'][2]['services'][0]['rateKey']);
                }
        
                // Check if the status code is 200
                if ($status === 200) {
                    return response()->json([
                        'status' => 'success',
                        'message' => trans('msg.list.success'),
                        'data' => $responseData,
                    ], $status);
                } else {
                    return response()->json([
                        'status' => 'failed',
                        'message' => trans('msg.list.failed'),
                        'data' => $responseData,
                    ], $status);
                }
            }
            else
            {
                $response = Http::withHeaders([
                    'Api-key' => config('constants.transfer.Api-key'),
                    'X-Signature' => $Signature,
                    'Accept' => 'application/json',
                    // 'Accept-Encoding' => 'gzip',
                    'Content-Type' => 'application/json',
                ])->post(config('constants.end-point').'/transfer-api/1.0/availability/routes/en/2/0/0');
                // echo json_encode(config('constants.end-point').'/transfer-api/1.0/availability/routes/'.$language.'/'.$adults.'/'.$children.'/'.$infants.'?'.$queryString);exit;
                $responseData = $response->json();
                // echo json_encode($response);
                // exit;
                $status = $response->status();
                // echo json_encode("Hello");exit;

                // Parse and set global variables from the response
                if (isset($responseData['routes'][0]['services'][0]['rateKey'])) {
                    Config::set('app.test_transfer_ratekey', $responseData['routes'][0]['services'][0]['rateKey']);
                }

                if (isset($responseData['routes'][2]['services'][0]['rateKey'])) {
                    Config::set('app.test_transfer_ratekey2', $responseData['routes'][2]['services'][0]['rateKey']);
                }

                // Check if the status code is 200
                if ($status === 200) {
                    return response()->json([
                        'status' => 'success',
                        'message' => trans('msg.list.success'),
                        'data' => $responseData,
                    ], $status);
                } else {
                    return response()->json([
                        'status' => 'failed',
                        'message' => trans('msg.list.failed'),
                        'data' => $responseData,
                    ], $status);
                }
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failed',
                'message' => trans('msg.error'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function confirmGPS(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'language' => 'required',
                'holder'  => 'required|json',
                'transfers'   => 'required|json',
                'clientReference' => 'required',
                'remarks' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }
            $data = [
                "holder" => json_decode($request->holder, TRUE),
                "transfers" => json_decode($request->transfers, TRUE),
                'clientReference' => $request->clientReference,
                'language' => $request->language,
                'remarks' => $request->remarks,
            ];
            $queryString = http_build_query($data);
            $signature = self::calculateSignature();
            $response = Http::withHeaders([
                'Api-key' => config('constants.transfer.Api-key'),
                'X-Signature' => $signature,
                'Content-Type' => 'application/json',
                
            ])->put(config('constants.end-point').'/transfer-api/1.0/bookings',$data);
            
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
