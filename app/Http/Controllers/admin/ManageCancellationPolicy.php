<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CancellationPolicy;
use Illuminate\Http\Request;

class ManageCancellationPolicy extends Controller
{
    public function list() {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Cancellation Policies');
        $data['policies']            = CancellationPolicy::get();
        
        return view('admin.cancellation-policy.list', $data);
    }

    public function editForm($id) {
        $policy = CancellationPolicy::find($id);
    
        if ($policy) {
            $data['previous_title']  = trans('msg.admin.Manage Cancellation Policies');
            $data['url']             = route('cancellation-policy.list');
            $data['title']           = trans('msg.admin.Edit Cancellation Policy');
            $data['policy']          = $policy;
           
            return view('admin.cancellation-policy.edit', $data);
        } else {
            return response()->json(['error' => trans('msg.admin.Cancellation Policy Not Found')]);
        }
    }

    public function edit(Request $request) {        
        $id = $request->id;
        $policy = CancellationPolicy::find($id);
    
        if (!$policy) {
            return redirect()->back()->with('error', trans('msg.admin.Cancellation Policy Not Found'));
        }
        
        $data = [
                'policy_en' => $request->policy_en ? $request->policy_en : $policy->policy_en,
                'policy_ar' => $request->policy_ar ? $request->policy_ar : $policy->policy_ar,
                'before_7_days' => $request->before_7_days ? $request->before_7_days : $policy->before_7_days,
                'within_24_hours' => $request->within_24_hours ? $request->within_24_hours : $policy->within_24_hours,
                'less_than_24_hours' => $request->less_than_24_hours ? $request->less_than_24_hours : $policy->less_than_24_hours,
            ];
    
        $update = CancellationPolicy::where('id', '=', $id)->update($data);

        if ($update) {
            return redirect()->route('cancellation-policy.list')->with('success', trans('msg.admin.Cancellation Policy Updated Successfully').'.');
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Failed to Update Cancellation Policy').'.');
        }
            
    }
}
