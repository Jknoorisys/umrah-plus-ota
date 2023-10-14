<?php

namespace App\Http\Controllers\api\transfer;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class ContentController extends Controller
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

    public function countries(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required','string'],
            'fields'   => ['required','string'],
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

            $data = [];        
            $data['fields'] = $request->fields;
            $data['language']= $request->language;
            
            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $offset = $request->offset ? $request->offset : "";
            if (!empty($offset) && isset($offset)) {
                $data['offset']= $request->offset;
            }

            $limit = $request->limit ? $request->limit : "";
            if (!empty($limit) && isset($limit)) {
                $data['limit']= $request->limit;
            }

            $queryString = http_build_query($data);
            
            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.transfer.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/transfer-cache-api/1.0/locations/countries?'. $queryString);
        
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

    public function terminals(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required','string'],
            'fields'   => ['required','string'],
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

            $data = [];        
    
            $data['fields'] = $request->fields;
            $data['language']= $request->language;
            
            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $offset = $request->offset ? $request->offset : "";
            if (!empty($offset) && isset($offset)) {
                $data['offset']= $request->offset;
            }

            $limit = $request->limit ? $request->limit : "";
            if (!empty($limit) && isset($limit)) {
                $data['limit']= $request->limit;
            }

            $queryString = http_build_query($data);
            
            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.transfer.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/transfer-cache-api/1.0/locations/terminals?'. $queryString);
        
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

    public function destinations(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required','string'],
            'fields'   => ['required','string'],
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

            $data = [];        
    
            $data['fields'] = $request->fields;
            $data['language']= $request->language;

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $offset = $request->offset ? $request->offset : "";
            if (!empty($offset) && isset($offset)) {
                $data['offset']= $request->offset;
            }

            $countryCode = $request->countryCode ? $request->countryCode : "";
            if (!empty($countryCode) && isset($countryCode)) {
                $data['countryCode']= $request->countryCode;
            }

            $limit = $request->limit ? $request->limit : "";
            if (!empty($limit) && isset($limit)) {
                $data['limit']= $request->limit;
            }

            $queryString = http_build_query($data);
            
            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.transfer.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/transfer-cache-api/1.0/locations/destinations?'. $queryString);
        
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

    public function categories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required','string'],
            'fields'   => ['required','string'],
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

            $data = [];        
    
            $data['fields'] = $request->fields;
            $data['language']= $request->language;

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $offset = $request->offset ? $request->offset : "";
            if (!empty($offset) && isset($offset)) {
                $data['offset']= $request->offset;
            }

            $limit = $request->limit ? $request->limit : "";
            if (!empty($limit) && isset($limit)) {
                $data['limit']= $request->limit;
            }

            $queryString = http_build_query($data);
            
            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.transfer.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/transfer-cache-api/1.0/locations/categories?'. $queryString);
        
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

    public function vehicals(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required','string'],
            'fields'   => ['required','string'],
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

            $data = [];        
    
            $data['fields'] = $request->fields;
            $data['language']= $request->language;

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $offset = $request->offset ? $request->offset : "";
            if (!empty($offset) && isset($offset)) {
                $data['offset']= $request->offset;
            }

            $limit = $request->limit ? $request->limit : "";
            if (!empty($limit) && isset($limit)) {
                $data['limit']= $request->limit;
            }

            $queryString = http_build_query($data);
            
            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.transfer.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/transfer-cache-api/1.0/masters/vehicles?'. $queryString);
        
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

    public function transferTypes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required','string'],
            'fields'   => ['required','string'],
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

            $data = [];        
    
            $data['fields'] = $request->fields;
            $data['language']= $request->language;

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $offset = $request->offset ? $request->offset : "";
            if (!empty($offset) && isset($offset)) {
                $data['offset']= $request->offset;
            }

            $limit = $request->limit ? $request->limit : "";
            if (!empty($limit) && isset($limit)) {
                $data['limit']= $request->limit;
            }

            $queryString = http_build_query($data);
            
            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.transfer.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/transfer-cache-api/1.0/masters/transferTypes?'. $queryString);
        
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

    public function currencies(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required','string'],
            'fields'   => ['required','string'],
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

            $data = [];        
    
            $data['fields'] = $request->fields;
            $data['language']= $request->language;

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $offset = $request->offset ? $request->offset : "";
            if (!empty($offset) && isset($offset)) {
                $data['offset']= $request->offset;
            }

            $limit = $request->limit ? $request->limit : "";
            if (!empty($limit) && isset($limit)) {
                $data['limit']= $request->limit;
            }

            $queryString = http_build_query($data);
            
            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.transfer.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/transfer-cache-api/1.0/currencies?'. $queryString);
        
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

    public function routes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destinationCode'   => ['required','string'],
            'language'   => ['required','string'],
            'fields'   => ['required','string'],
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

            $data = [];        
    
            $data['fields'] = $request->fields;
            $data['language']= $request->language;
            $data['destinationCode']= $request->destinationCode;
            

            $offset = $request->offset ? $request->offset : "";
            if (!empty($offset) && isset($offset)) {
                $data['offset']= $request->offset;
            }

            $limit = $request->limit ? $request->limit : "";
            if (!empty($limit) && isset($limit)) {
                $data['limit']= $request->limit;
            }

            $queryString = http_build_query($data);
            
            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.transfer.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/transfer-cache-api/1.0/routes?'. $queryString);
        
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

    public function hotels(Request $request)
    {
        $validator = Validator::make($request->all(), [
            
            'language'   => ['required','string'],
            'fields'   => ['required','string'],
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

            $data = [];        
    
            $data['fields'] = $request->fields;
            $data['language']= $request->language;

            $destinationCodes = $request->destinationCodes ? $request->destinationCodes : "";
            if (!empty($destinationCodes) && isset($destinationCodes)) {
                $data['destinationCodes']= $request->destinationCodes;
            }

            $countryCodes = $request->countryCodes ? $request->countryCodes : "";
            if (!empty($countryCodes) && isset($countryCodes)) {
                $data['countryCodes']= $request->countryCodes;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $giataCodes = $request->giataCodes ? $request->giataCodes : "";
            if (!empty($giataCodes) && isset($giataCodes)) {
                $data['giataCodes']= $request->giataCodes;
            }


            $offset = $request->offset ? $request->offset : "";
            if (!empty($offset) && isset($offset)) {
                $data['offset']= $request->offset;
            }

            $limit = $request->limit ? $request->limit : "";
            if (!empty($limit) && isset($limit)) {
                $data['limit']= $request->limit;
            }

            $queryString = http_build_query($data);
            
            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.transfer.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/transfer-cache-api/1.0/hotels?'. $queryString);
        
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

    public function pickup(Request $request)
    {
        $validator = Validator::make($request->all(), [
          
            'language'   => ['required','string'],
            'fields'   => ['required','string'],
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

            $data = [];        
    
            $data['fields'] = $request->fields;
            $data['language']= $request->language;

            $countryCodes = $request->countryCodes ? $request->countryCodes : "";
            if (!empty($countryCodes) && isset($countryCodes)) {
                $data['countryCodes']= $request->countryCodes;
            }

            $offset = $request->offset ? $request->offset : "";
            if (!empty($offset) && isset($offset)) {
                $data['offset']= $request->offset;
            }

            $limit = $request->limit ? $request->limit : "";
            if (!empty($limit) && isset($limit)) {
                $data['limit']= $request->limit;
            }

            $codes = $request->codes ? $request->codes : "";
            if (!empty($codes) && isset($codes)) {
                $data['codes']= $request->codes;
            }

            $queryString = http_build_query($data);
            
            $Signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.transfer.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->get(config('constants.end-point').'/transfer-cache-api/1.0/pickups?'. $queryString);
        
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
