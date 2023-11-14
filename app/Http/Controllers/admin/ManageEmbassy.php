<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Embassy;
use Illuminate\Http\Request;

class ManageEmbassy extends Controller
{
    public function list() {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Embassy');
        $data['embassies']               = Embassy::orderBy('created_at', 'desc')->get();
        
        return view('admin.embassy.list', $data);
    }

    public function addForm() {
        $data['previous_title']      = trans('msg.admin.Manage Embassy');
        $data['url']                 = route('embassy.list');
        $data['title']               = trans('msg.admin.Add Embassy');
        
        return view('admin.embassy.add', $data);
    }

    public function add(Request $request) {

        $validatedData = $request->validate([
            'embassy' => 'required',
            'address' => 'required',
        ]);

        $insert = Embassy::create($validatedData);

        if ($insert) {
            return redirect()->route('embassy.list')->with('success', trans('msg.admin.Embassy Added Successfully').'.');
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Failed to Add Embassy'))->withInput();
        }
    }

    public function editForm($id) {
        $embassy = Embassy::find($id);

        if ($embassy) {
            $data['previous_title']  = trans('msg.admin.Manage Embassy');
            $data['url']             = route('embassy.list');
            $data['title']           = trans('msg.admin.Edit Embassy');
            $data['embassy']         = $embassy;
            return view('admin.embassy.edit', $data);
        } else {
            return response()->json(['error' => trans('msg.admin.Embassy Not Found')]);
        }
    }

    public function edit(Request $request) {
        
        $id = $request->id;
        $embassy = Embassy::find($id);
    
        if (!$embassy) {
            return redirect()->back()->with('error', trans('msg.admin.Embassy Not Found'));
        }

        $validatedData = $request->validate([
            'embassy' => 'required',
            'address' => 'required',
        ]);
    
        $update = $embassy->update($validatedData);

        if ($update) {
            return redirect()->route('embassy.list')->with('success', trans('msg.admin.Embassy Updated Successfully').'.');
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Failed to Update Embassy').'.');
        }
            
    }

    public function changeStatus(Request $request) {
        $embassy = Embassy::find($request->embassy_id);

        if (!$embassy) {
            return response()->json(['error' => trans('msg.admin.Embassy Not Found')]);
        }

        $embassy->status = $request->status;
        $update = $embassy->save();

        if ($update) {
            $status = $request->status == 'active' ? 'Activated' : 'Deactivated';
            return response()->json(['message' => trans('msg.admin.Embassy :status Successfully', ['status' => $status])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }

    public function delete(Request $request) {
        $embassy = Embassy::find($request->embassy_id);
        if (!$embassy) {
            return response()->json(['error' => trans('msg.admin.Embassy Not Found')]);
        }

        $delete = $embassy->delete();

        if ($delete) {
            return response()->json(['message' => trans('msg.admin.Embassy :status Successfully', ['status' => 'Deleted'])]);
        } else {
            return response()->json(['error' => trans('msg.admin.Please try again...')]);
        }
    }
}
