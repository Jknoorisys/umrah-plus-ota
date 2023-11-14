<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Markup;
use App\Models\VisaCountry;
use App\Models\VisaPackages;
use App\Models\VisaTypes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManageVisaTypes extends Controller
{
    public function list() {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Visa Types');
        $data['types']               = VisaTypes::with('package')->orderBy('created_at', 'desc')->get();
        
        return view('admin.visa-type.list', $data);
    }

    public function addForm() {
        $data['previous_title']      = trans('msg.admin.Manage Visa Types');
        $data['url']                 = route('visa-type.list');
        $data['title']               = trans('msg.admin.Add Visa Type');
        $data['packages']            = VisaPackages::where('status', '=', 'active')->orderBy('created_at', 'desc')->get();
        
        return view('admin.visa-type.add', $data);
    }

    public function add(Request $request) {

        $validatedData = $request->validate([
            'package_id' => 'required',
            'type' => 'required',
            'processing_time' => 'required',
            'stay_period' => 'required',
            'validity' => 'required',
            'entry' => 'required',
            'fees' => 'required',
            'currency' => 'required',
        ]);

        $insert = VisaTypes::create($validatedData);

        if ($insert) {
            return redirect()->route('visa-type.list')->with('success', trans('msg.admin.Visa Type Added Successfully').'.');
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Failed to Add Visa Type'))->withInput();
        }
    }

    public function editForm($id) {
        $type = VisaTypes::find($id);

        if ($type) {
            $data['previous_title']  = trans('msg.admin.Manage Visa Types');
            $data['url']             = route('visa-type.list');
            $data['title']           = trans('msg.admin.Edit Visa Type');
            $data['packages']        = VisaPackages::where('status', '=', 'active')->orderBy('created_at', 'desc')->get();
            $data['type']            = $type;

            return view('admin.visa-type.edit', $data);
        } else {
            return response()->json(['error' => trans('msg.admin.Visa Type Not Found')]);
        }
    }

    public function edit(Request $request) {
        
        $id = $request->id;
        $visaType = VisaTypes::find($id);
    
        if (!$visaType) {
            return redirect()->back()->with('error', trans('msg.admin.Visa Type Not Found'));
        }

        $validatedData = $request->validate([
            'package_id' => 'required',
            'type' => 'required',
            'processing_time' => 'required',
            'stay_period' => 'required',
            'validity' => 'required',
            'entry' => 'required',
            'fees' => 'required',
            'currency' => 'required',
        ]);
    
        $update = $visaType->update($validatedData);

        if ($update) {
            return redirect()->route('visa-type.list')->with('success', trans('msg.admin.Visa Type Updated Successfully').'.');
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Failed to Update Visa Type').'.');
        }
            
    }

    public function changeStatus(Request $request) {
        $type = VisaTypes::find($request->type_id);

        if (!$type) {
            return response()->json(['error' => trans('msg.admin.Visa Type Not Found')]);
        }

        $type->status = $request->status;
        $update = $type->save();

        if ($update) {
            $status = $request->status == 'active' ? 'Activated' : 'Deactivated';
            return response()->json(['message' => trans('msg.admin.Visa Type :status Successfully', ['status' => $status])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }

    public function delete(Request $request) {
        $type = VisaTypes::find($request->type_id);
        if (!$type) {
            return response()->json(['error' => trans('msg.admin.Visa Type Not Found')]);
        }

        $delete = $type->delete();

        if ($delete) {
            return response()->json(['message' => trans('msg.admin.Visa Type :status Successfully', ['status' => 'Deleted'])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }

    public function toggleFeatured(Request $request) {
        $type = VisaTypes::find($request->id);

        if (!$type) {
            return response()->json(['error' => trans('msg.admin.Visa Type Not Found')]);
        }

        $type->is_featured = $request->status;
        $update = $type->save();

        if ($update) {
            $status = $request->status == 'yes' ? 'Featured' : 'Unfeatuted';
            return response()->json(['message' => trans('msg.admin.Visa Type :status Successfully', ['status' => $status])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }
}
