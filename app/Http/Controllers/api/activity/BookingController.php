<?php

namespace App\Http\Controllers\api\activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

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
            $languages = $request->input('language');
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

    // public function filterCalender(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'filters' => ['required','array'],
    //             'paxes' => ['required','array'],
    //             'from' => ['required','date'],
    //             'to' => ['required','date'],
    //             'language' => ['required','string'],
    //             'pagination' => ['required','array'],
    //             'order' => ['required','string'],
    //             // 'codes' => 'string'
    //                     ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => 'failed',
    //                 'errors' => $validator->errors(),
    //                 'message' => trans('msg.validation'),
    //             ], 400);
    //         }

    //         $languages = $request->input('language');
    //         $activateMigration = $request->input('activateMigration');
    //         $filters = $request->input('filters');
    //         $paxes = $request->input('paxes');
    //         $from = $request->input('from');
    //         $to = $request->input('to');
    //         $pagination = $request->input('pagination');
    //         $order = $request->input('order');
    //         // $codes = $request->input('codes');

    //         $signature = self::calculateSignature();

    //         $response = Http::withHeaders([
    //             'Api-key' => config('constants.activites.Api-key'),
    //             'X-Signature' => $signature,
    //             'Accept' => 'application/json',
    //             'Accept-Encoding' => 'gzip',
    //             'Content-Type' => 'application/json',
    //         ])->post(config('constants.end-point') . '/activity-api/3.0/activities/availability/', [
    //                         'activationMigration' => $activateMigration,
    //                         'filters' => $filters,
    //                         'paxes' => $paxes,
    //                         'from' => $from,
    //                         'to' => $to,
    //                         'language' => $languages,
    //                         'pagination' => $pagination,
    //                         'order' => $order,
    //                         // 'codes' => $codes
    //                     ]);
    //                     // echo json_encode($filters);exit;
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
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => trans('msg.error'),
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // public function filterByFactsheet(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'filters' => ['required','array'],
    //             'from' => ['required','date'],
    //             'to' => ['required','date'],
    //             'language' => ['required','string'],
    //             'pagination' => ['required','array'],
    //             'order' => ['required','string'],
    //             // 'codes' => 'string'
    //                     ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => 'failed',
    //                 'errors' => $validator->errors(),
    //                 'message' => trans('msg.validation'),
    //             ], 400);
    //         }

    //         $languages = $request->input('language');
    //         $activateMigration = $request->input('activateMigration');
    //         $filters = $request->input('filters');
    //         $paxes = $request->input('paxes');
    //         $from = $request->input('from');
    //         $to = $request->input('to');
    //         $pagination = $request->input('pagination');
    //         $order = $request->input('order');
    //         // $codes = $request->input('codes');

    //         $signature = self::calculateSignature();

    //         $response = Http::withHeaders([
    //             'Api-key' => config('constants.activites.Api-key'),
    //             'X-Signature' => $signature,
    //             'Accept' => 'application/json',
    //             'Accept-Encoding' => 'gzip',
    //             'Content-Type' => 'application/json',
    //         ])->post(config('constants.end-point') . '/activity-api/3.0/activities/', [
    //                         'activationMigration' => $activateMigration,
    //                         'filters' => $filters,
    //                         'paxes' => $paxes,
    //                         'from' => $from,
    //                         'to' => $to,
    //                         'language' => $languages,
    //                         'pagination' => $pagination,
    //                         'order' => $order,
    //                         // 'codes' => $codes
    //                     ]);
    //                     // echo json_encode($filters);exit;
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
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => trans('msg.error'),
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // public function filterByActivity(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'filters' => ['required','array'],
    //             'from' => ['required','date'],
    //             'to' => ['required','date'],
    //             'language' => ['required','string'],
    //             'pagination' => ['required','array'],
    //             'order' => ['required','string'],
    //             // 'codes' => 'string'
    //                     ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => 'failed',
    //                 'errors' => $validator->errors(),
    //                 'message' => trans('msg.validation'),
    //             ], 400);
    //         }

    //         $languages = $request->input('language');
    //         $activateMigration = $request->input('activateMigration');
    //         $filters = $request->input('filters');
    //         $paxes = $request->input('paxes');
    //         $from = $request->input('from');
    //         $to = $request->input('to');
    //         $pagination = $request->input('pagination');
    //         $order = $request->input('order');
    //         // $codes = $request->input('codes');

    //         $signature = self::calculateSignature();

    //         $response = Http::withHeaders([
    //             'Api-key' => config('constants.activites.Api-key'),
    //             'X-Signature' => $signature,
    //             'Accept' => 'application/json',
    //             'Accept-Encoding' => 'gzip',
    //             'Content-Type' => 'application/json',
    //         ])->post(config('constants.end-point') . '/activity-api/3.0/activities/', [
    //                         'activationMigration' => $activateMigration,
    //                         'filters' => $filters,
    //                         'paxes' => $paxes,
    //                         'from' => $from,
    //                         'to' => $to,
    //                         'language' => $languages,
    //                         'pagination' => $pagination,
    //                         'order' => $order,
    //                         // 'codes' => $codes
    //                     ]);
    //                     // echo json_encode($filters);exit;
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
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => trans('msg.error'),
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // public function filterByHotel(request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'filters' => ['required','array'],
    //             'from' => ['required','date'],
    //             'to' => ['required','date'],
    //             'language' => ['required','string'],
    //             'pagination' => ['required','array'],
    //             'order' => ['required','string'],
    //             // 'codes' => 'string'
    //                     ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => 'failed',
    //                 'errors' => $validator->errors(),
    //                 'message' => trans('msg.validation'),
    //             ], 400);
    //         }

    //         $languages = $request->input('language');
    //         $activateMigration = $request->input('activateMigration');
    //         $filters = $request->input('filters');
    //         $paxes = $request->input('paxes');
    //         $from = $request->input('from');
    //         $to = $request->input('to');
    //         $pagination = $request->input('pagination');
    //         $order = $request->input('order');
    //         // $codes = $request->input('codes');

    //         $signature = self::calculateSignature();

    //         $response = Http::withHeaders([
    //             'Api-key' => config('constants.activites.Api-key'),
    //             'X-Signature' => $signature,
    //             'Accept' => 'application/json',
    //             'Accept-Encoding' => 'gzip',
    //             'Content-Type' => 'application/json',
    //         ])->post(config('constants.end-point') . '/activity-api/3.0/activities/', [
    //                         'activationMigration' => $activateMigration,
    //                         'filters' => $filters,
    //                         'paxes' => $paxes,
    //                         'from' => $from,
    //                         'to' => $to,
    //                         'language' => $languages,
    //                         'pagination' => $pagination,
    //                         'order' => $order,
    //                         // 'codes' => $codes
    //                     ]);
    //                     // echo json_encode($filters);exit;
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
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => trans('msg.error'),
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // public function filterBySegment(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'filters' => ['required','array'],
    //             'from' => ['required','date'],
    //             'to' => ['required','date'],
    //             'language' => ['required','string'],
    //             'pagination' => ['required','array'],
    //             'order' => ['required','string'],
    //             // 'codes' => 'string'
    //                     ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => 'failed',
    //                 'errors' => $validator->errors(),
    //                 'message' => trans('msg.validation'),
    //             ], 400);
    //         }

    //         $languages = $request->input('language');
    //         $activateMigration = $request->input('activateMigration');
    //         $filters = $request->input('filters');
    //         $paxes = $request->input('paxes');
    //         $from = $request->input('from');
    //         $to = $request->input('to');
    //         $pagination = $request->input('pagination');
    //         $order = $request->input('order');
    //         // $codes = $request->input('codes');

    //         $signature = self::calculateSignature();

    //         $response = Http::withHeaders([
    //             'Api-key' => config('constants.activites.Api-key'),
    //             'X-Signature' => $signature,
    //             'Accept' => 'application/json',
    //             'Accept-Encoding' => 'gzip',
    //             'Content-Type' => 'application/json',
    //         ])->post(config('constants.end-point') . '/activity-api/3.0/activities/', [
    //                         'activationMigration' => $activateMigration,
    //                         'filters' => $filters,
    //                         'paxes' => $paxes,
    //                         'from' => $from,
    //                         'to' => $to,
    //                         'language' => $languages,
    //                         'pagination' => $pagination,
    //                         'order' => $order,
    //                         // 'codes' => $codes
    //                     ]);
    //                     // echo json_encode($filters);exit;
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
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => trans('msg.error'),
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // public function filterActivityModality(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'filters' => ['required','array'],
    //             'from' => ['required','date'],
    //             'to' => ['required','date'],
    //             'language' => ['required','string'],
    //             'pagination' => ['required','array'],
    //             'order' => ['required','string'],
    //             // 'codes' => 'string'
    //                     ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => 'failed',
    //                 'errors' => $validator->errors(),
    //                 'message' => trans('msg.validation'),
    //             ], 400);
    //         }

    //         $languages = $request->input('language');
    //         $activateMigration = $request->input('activateMigration');
    //         $filters = $request->input('filters');
    //         $paxes = $request->input('paxes');
    //         $from = $request->input('from');
    //         $to = $request->input('to');
    //         $pagination = $request->input('pagination');
    //         $order = $request->input('order');
    //         // $codes = $request->input('codes');

    //         $signature = self::calculateSignature();

    //         $response = Http::withHeaders([
    //             'Api-key' => config('constants.activites.Api-key'),
    //             'X-Signature' => $signature,
    //             'Accept' => 'application/json',
    //             'Accept-Encoding' => 'gzip',
    //             'Content-Type' => 'application/json',
    //         ])->post(config('constants.end-point') . '/activity-api/3.0/activities/', [
    //                         'activationMigration' => $activateMigration,
    //                         'filters' => $filters,
    //                         'paxes' => $paxes,
    //                         'from' => $from,
    //                         'to' => $to,
    //                         'language' => $languages,
    //                         'pagination' => $pagination,
    //                         'order' => $order,
    //                         // 'codes' => $codes
    //                     ]);
    //                     // echo json_encode($filters);exit;
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
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => trans('msg.error'),
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    // public function filterByPrices(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'filters' => ['required','array'],
    //             'from' => ['required','date'],
    //             'to' => ['required','date'],
    //             'language' => ['required','string'],
    //             'pagination' => ['required','array'],
    //             'order' => ['required','string'],
    //             // 'codes' => 'string'
    //                     ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => 'failed',
    //                 'errors' => $validator->errors(),
    //                 'message' => trans('msg.validation'),
    //             ], 400);
    //         }

    //         $languages = $request->input('language');
    //         $activateMigration = $request->input('activateMigration');
    //         $filters = $request->input('filters');
    //         $paxes = $request->input('paxes');
    //         $from = $request->input('from');
    //         $to = $request->input('to');
    //         $pagination = $request->input('pagination');
    //         $order = $request->input('order');
    //         // $codes = $request->input('codes');

    //         $signature = self::calculateSignature();

    //         $response = Http::withHeaders([
    //             'Api-key' => config('constants.activites.Api-key'),
    //             'X-Signature' => $signature,
    //             'Accept' => 'application/json',
    //             'Accept-Encoding' => 'gzip',
    //             'Content-Type' => 'application/json',
    //         ])->post(config('constants.end-point') . '/activity-api/3.0/activities/', [
    //                         'activationMigration' => $activateMigration,
    //                         'filters' => $filters,
    //                         'paxes' => $paxes,
    //                         'from' => $from,
    //                         'to' => $to,
    //                         'language' => $languages,
    //                         'pagination' => $pagination,
    //                         'order' => $order,
    //                         // 'codes' => $codes
    //                     ]);
    //                     // echo json_encode($filters);exit;
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
    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => trans('msg.error'),
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
    
    
    
}
