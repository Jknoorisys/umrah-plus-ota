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
    public function countries() {
        try {
            $countires = MasterCountry::all();
            $total = MasterCountry::count();

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

    public function languages() {
        try {
            $languages = MasterLanguage::all();
            $total = MasterLanguage::count();

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

    public function hotels() {
        try {
            $hotels = MasterHotel::all();
            $total = MasterHotel::count();

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
            $total = MasterDestination::count();

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
