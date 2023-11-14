<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Embassy;
use App\Models\VisaPackages;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManageVisaPackages extends Controller
{
    public function list() {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Visa Package');
        $data['packages']            = VisaPackages::orderBy('created_at', 'desc')->get();
        
        return view('admin.visa-package.list', $data);
    }

    public function addForm() {
        $data['previous_title']      = trans('msg.admin.Manage Visa Package');
        $data['url']                 = route('visa-package.list');
        $data['title']               = trans('msg.admin.Add Visa Package');
        $data['embassies']           = Embassy::where('status', '=', 'active')->orderBy('created_at', 'desc')->get();
        
        return view('admin.visa-package.add', $data);
    }

    public function add(Request $request) {

        $validatedData = $request->validate([
            'country' => 'required|unique:visa_packages',
            'processing_time' => 'required',
            'process' => 'required',
            'documents' => 'required',
            'embassy' => 'required',
        ]);

        $data = [
            'country' => $request->country,
            'processing_time' => $request->processing_time,
            'process' => $request->process,
            'documents' => $request->documents,
            'embassy' => $request->embassy ? implode(',', $request->embassy) : '',
        ];

        $insert = VisaPackages::create($data);

        if ($insert) {
            return redirect()->route('visa-package.list')->with('success', trans('msg.admin.Visa Package Added Successfully').'.');
        } else {
            return back()->with('error', trans('msg.admin.Failed to Add Visa Package'));
        }
    }

    public function editForm($id) {
        $package = VisaPackages::find($id);

        if ($package) {
            $data['previous_title']  = trans('msg.admin.Manage Roles');
            $data['url']             = route('role.list');
            $data['title']           = trans('msg.admin.Edit Role');
            $data['embassies']       = Embassy::where('status', '=', 'active')->orderBy('created_at', 'desc')->get();
            $data['package']         = $package;

            return view('admin.visa-package.edit', $data);
        } else {
            return back()->with('success', trans('msg.admin.Visa Package Not Found'));
        }
    }

    public function edit(Request $request)
    {
        $validatedData = $request->validate([
            'country' => ['required', Rule::unique('visa_packages')->ignore($request->id)],
            'processing_time' => 'required',
            'process' => 'required',
            'documents' => 'required',
            'embassy' => 'required',
        ]);

        $package = VisaPackages::find($request->id);

        if (!$package) {
            return back()->with('error', trans('msg.admin.Visa Package Not Found'));
        }

        $package->country = $request->country;
        $package->processing_time = $request->processing_time;
        $package->process = $request->process;
        $package->documents = $request->documents;
        $package->embassy = $request->embassy ? implode(',', $request->embassy) : '';
        $update = $package->save();

        if ($update) {
            return redirect()->route('visa-package.list')->with('success', trans('msg.admin.Visa Package Updated Successfully'));
        } else {
            return back()->with('error', trans('msg.admin.Failed to Update Visa Package'));
        }
    }

    public function changeStatus(Request $request) {
        $package = VisaPackages::find($request->package_id);
        
        if (!$package) {
            return response()->json(['error' => trans('msg.admin.Visa Package Not Found')]);
        }

        $package->status = $request->status;
        $update = $package->save();

        if ($update) {
            $status = $request->status == 'active' ? 'Activated' : 'Deactivated';
            return response()->json(['message' => trans('msg.admin.Visa Package :status Successfully', ['status' => $status])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }

    public function toggleFeatured(Request $request) {
        $package = VisaPackages::find($request->id);

        if (!$package) {
            return response()->json(['error' => trans('msg.admin.Visa Package Not Found')]);
        }

        $package->is_featured = $request->status;
        $update = $package->save();

        if ($update) {
            $status = $request->status == 'yes' ? 'Featured' : 'Unfeatuted';
            return response()->json(['message' => trans('msg.admin.Visa Package :status Successfully', ['status' => $status])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }

    public function delete(Request $request) {
        $package = VisaPackages::find($request->package_id);

        if (!$package) {
            return response()->json(['error' => trans('msg.admin.Visa Package Not Found')]);
        }

        $delete = $package->delete();

        if ($delete) {
            return response()->json(['message' => trans('msg.admin.Visa Package :status Successfully', ['status' => 'Deleted'])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }
}
