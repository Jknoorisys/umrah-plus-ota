<?php

namespace App\Http\Controllers\api\activity;

use App\Http\Controllers\Controller;
use App\Models\MasterDestination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class ContentController extends Controller
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

    public function languages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required', 'string'],
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

            $Signature = self::calculateSignature();
            // echo json_encode($Signature);exit;
            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
            ])->get(config('constants.end-point') . '/activity-content-api/3.0/languages');

            $responseData = $response->json();

            $status = $response->status();

            if ($status == "200") {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'data'      => $responseData
                ], $status);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                    'data'      => $responseData
                ], $status);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ], 500);
        }
    }

    public function currencies(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required', 'string'],
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

            $languages = $request->language;
            $Signature = self::calculateSignature();
            // echo json_encode($Signature);exit;
            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
            ])->get(config('constants.end-point') . '/activity-content-api/3.0/currencies/' . $languages);

            $responseData = $response->json();

            $status = $response->status();

            if ($status == "200") {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'data'      => $responseData
                ], $status);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                    'data'      => $responseData
                ], $status);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ], 500);
        }
    }

    public function segments(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required', 'string'],
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

            $languages = $request->language;
            $Signature = self::calculateSignature();
            // echo json_encode($Signature);exit;
            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
            ])->get(config('constants.end-point') . '/activity-content-api/3.0/segments/' . $languages);

            $responseData = $response->json();

            $status = $response->status();

            if ($status == "200") {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'data'      => $responseData
                ], $status);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                    'data'      => $responseData
                ], $status);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ], 500);
        }
    }

    public function countries(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required', 'string'],
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

            $languages = $request->language;
            $Signature = self::calculateSignature();
            // echo json_encode($Signature);exit;
            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
            ])->get(config('constants.end-point') . '/activity-content-api/3.0/countries/' . $languages);

            $responseData = $response->json();

            $status = $response->status();

            if ($status == "200") {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'data'      => $responseData
                ], $status);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                    'data'      => $responseData
                ], $status);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ], 500);
        }
    }

    public function destinations(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required', 'string'],
            // 'country'   => ['required', 'string'],
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

            $languages = $request->language;
            // $country = $request->country;

            $data = MasterDestination::all();
            $total = $data->count();
            // $Signature = self::calculateSignature();
            // echo json_encode($Signature);exit;
            // $response = Http::withHeaders([
            //     'Api-key' => config('constants.activites.Api-key'),
            //     'X-Signature' => $Signature,
            //     'Accept' => 'application/json',
            //     'Accept-Encoding' => 'gzip',
            // ])->get(config('constants.end-point') . '/activity-content-api/3.0/destinations/' . $languages . '/' . $country);

            // $responseData = $response->json();

            // $status = $response->status();

            if ($data) {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'total'     => $total,
                    'data'      => $data
                ], 200);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                    'data'      => $data
                ], 500);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ], 500);
        }
    }

    public function content_single(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required', 'string'],
            'activity'   => ['required', 'string'],
            'modality'   => ['required', 'string'],
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

            $languages = $request->language;
            $activity = $request->activity;
            $modality = $request->modality;
            $Signature = self::calculateSignature();
            // echo json_encode($Signature);exit;
            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
            ])->get(config('constants.end-point') . '/activity-content-api/3.0/activities/' . $languages . '/' . $activity . '/' . $modality);

            $responseData = $response->json();

            $status = $response->status();

            if ($status == "200") {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'data'      => $responseData
                ], $status);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                    'data'      => $responseData
                ], $status);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ], 500);
        }
    }

    public function content_multi(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'language' => ['required', 'string'],
                'codes' => ['required', 'array'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failed',
                    'errors' => $validator->errors(),
                    'message' => trans('msg.validation'),
                ], 400);
            }

            $languages = $request->input('language');
            $codes = $request->input('codes');

            $signature = self::calculateSignature();

            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'Content-Type' => 'application/json',
            ])->post(config('constants.end-point') . '/activity-content-api/3.0/activities', [
                'language' => $languages,
                'codes' => $codes,
            ]);

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


    public function hotels(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language'   => ['required', 'string'],
            'destination'   => ['required'],

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

            $languages = $request->language;
            $destination = $request->destination;

            $Signature = self::calculateSignature();
            // echo json_encode($Signature);exit;
            $response = Http::withHeaders([
                'Api-key' => config('constants.activites.Api-key'),
                'X-Signature' => $Signature,
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
            ])->get(config('constants.end-point') . '/activity-content-api/3.0/hotels/' . $languages . '/' . $destination);

            $responseData = $response->json();

            $status = $response->status();

            if ($status == "200") {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'data'      => $responseData
                ], $status);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                    'data'      => $responseData
                ], $status);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ], 500);
        }
    }
}
