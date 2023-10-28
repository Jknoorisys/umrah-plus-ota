<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\VisaCountry;
use Illuminate\Http\Request;

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
        $country = VisaCountry::findOrFail($id);
        return response()->json(['country' => $country]);
    }

    public function edit(Request $request, $id)
    {
        $validatedData = $request->validate([
            'country' => 'required|unique:visa_countries,country,' . $id,
        ]);

        $update = VisaCountry::where('id', '=', $id)->update(['country' => $request->country]);

        if ($update) {
            return response()->json(['message' => trans('msg.admin.Visa Country Updated Successfully')]);
        } else {
            return response()->json(['error' => trans('msg.admin.Failed to Update Visa Country')]);
        }
    }

}
