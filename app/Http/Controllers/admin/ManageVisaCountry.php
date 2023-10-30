<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\VisaCountry;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManageVisaCountry extends Controller
{
    public function list() {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Visa Country');
        $data['countries']               = VisaCountry::orderBy('created_at', 'desc')->get();
        
        return view('admin.visa-country.list', $data);
    }

    public function add(Request $request) {
        $validatedData = $request->validate([
            'country' => 'required|unique:visa_countries',
        ]);

        $insert = VisaCountry::create($validatedData);

        if ($insert) {
            $newCountry = $insert;
            return response()->json(['message' => trans('msg.admin.Visa Country Added Successfully').'.', 'country' => $newCountry]);
        } else {
            return response()->json(['error' => trans('msg.admin.Failed to Add Visa Country')]);
        }
    }

    public function editForm($id) {
        $country = VisaCountry::find($id);

        if ($country) {
            return response()->json(['country' => $country]);
        } else {
            return response()->json(['message' => trans('msg.admin.Visa Country Not Found')]);
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'country'     => ['required', Rule::unique('visa_countries')->ignore($request->id)],
        ]);

        $country = VisaCountry::find($request->id);

        if (!$country) {
            return response()->json(['message' => trans('msg.admin.Visa Country Not Found')]);
        }

        $country->country = $request->country;
        $update = $country->save();

        if ($update) {
            return response()->json(['message' => trans('msg.admin.Visa Country Updated Successfully')]);
        } else {
            return response()->json(['error' => trans('msg.admin.Failed to Update Visa Country')]);
        }
    }

    public function changeStatus(Request $request) {
        $country = VisaCountry::find($request->country_id);
        
        if (!$country) {
            return response()->json(['error' => trans('msg.admin.Visa Country Not Found')]);
        }

        $country->status = $request->status;
        $update = $country->save();

        if ($update) {
            $status = $request->status == 'active' ? 'Activated' : 'Deactivated';
            return response()->json(['message' => trans('msg.admin.Visa Country :status Successfully', ['status' => $status])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }

    public function toggleFeatured(Request $request)
    {
        $country = VisaCountry::find($request->id);

        if (!$country) {
            return response()->json(['error' => trans('msg.admin.Visa Country Not Found')]);
        }

        $country->status = $request->status;
        $update = $country->save();

        if ($update) {
            $status = $request->status == 'yes' ? 'Featured' : 'Unfeatuted';
            return response()->json(['message' => trans('msg.admin.Visa Country :status Successfully', ['status' => $status])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }

    public function delete(Request $request) {
        $country = VisaCountry::find($request->country_id);

        if (!$country) {
            return response()->json(['error' => trans('msg.admin.Visa Country Not Found')]);
        }

        $delete = $country->delete();

        if ($delete) {
            return response()->json(['message' => trans('msg.admin.Visa Country :status Successfully', ['status' => 'Deleted'])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }
}
