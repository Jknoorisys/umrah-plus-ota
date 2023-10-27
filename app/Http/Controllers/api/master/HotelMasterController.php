<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\MasterCountry;
use App\Models\MasterDestination;
use App\Models\MasterHotel;
use App\Models\MasterLanguage;
use Illuminate\Http\Request;

class HotelMasterController extends Controller
{
    public function countries(Request $request) {
        try {
            $search = $request->search ? $request->search : '';

            $countires = MasterCountry::where('country', 'like', '%'.$search.'%')->get();
            $total = $countires->count();

            if (!empty($countires)) {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'total'     => $total,
                    'data'      => $countires
                ],200);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                ],400);
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

            $search = $request->search ? $request->search : '';

            $languages = MasterLanguage::where('language', 'like', '%'.$search.'%')->get();
            $total = $languages->count();

            if (!empty($languages)) {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'total'     => $total,
                    'data'      => $languages
                ],200);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                ],400);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.error'),
                'error'     => $e->getMessage()
            ],500);
        }
    }

    public function hotels(Request $request) {
        try {
            $search = $request->search ? $request->search : '';

            $hotels = MasterHotel::where('hotel', 'like', '%'.$search.'%')->get();
            $total = $hotels->count();

            if (!empty($hotels)) {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'total'     => $total,
                    'data'      => $hotels
                ],200);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                ],400);
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
            $search = $request->search ? $request->search : '';

            $destinations = MasterDestination::where('destination', 'like', '%'.$search.'%')->get();
            $total = $destinations->count();

            if (!empty($destinations)) {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'total'     => $total,
                    'data'      => $destinations
                ],200);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                ],400);
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
