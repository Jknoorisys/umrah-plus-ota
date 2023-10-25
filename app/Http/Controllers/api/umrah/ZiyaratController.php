<?php

namespace App\Http\Controllers\api\umrah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ZiyaratController extends Controller
{
    public function list(Request $request) {
        $validator = Validator::make($request->all(), [
            'page_no'   => ['required','numeric', Rule::notIn('undefined')],
            'search'    => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 'failed',
                'message'   => trans('msg.validation'),
                'errors'    => $validator->errors(),
            ], 400);
        } 

        try {
            $page = $request->input(key: 'page', default: 1);
            $limit = 10;
            $offset = ($page - 1) * $limit;
            $search = $request->search;

            $query = DB::connection('umrahaddons')->table('tbl_package as package')
                                                    ->leftJoin('tbl_provider as provider', 'package.provider_id', '=', 'provider.id')
                                                    ->where('package.status', '=', 'active');

            if (isset($search) && !empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('package.package_title', 'like', '%' . $search . '%')
                        ->orWhere('package.city_loaction', 'like', '%' . $search . '%')
                        ->orWhere('package.pickup_loaction', 'like', '%' . $search . '%')
                        ->orWhere('provider.firstname', 'like', '%' . $search . '%')
                        ->orWhere('provider.lastname', 'like', '%' . $search . '%');
                });
            }

            $total = $query->count();

            $packages = $query->orderByDesc('package.id')
                                ->offset($offset)
                                ->limit($limit)
                                ->get(['package.*', DB::raw("CONCAT(provider.firstname,' ',provider.lastname) as provider_name")]);

            if (!empty($packages)) {
                return response()->json([
                    'status'    => 'success',
                    'message'   => trans('msg.list.success'),
                    'total'     => $total,
                    'data'      => $packages,
                ], 200);
            } else {
                return response()->json([
                    'status'    => 'failed',
                    'message'   => trans('msg.list.failed'),
                ], 400);
            }

        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'failed',
                'message' => trans('msg.error'),
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
