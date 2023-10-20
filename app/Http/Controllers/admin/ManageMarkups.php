<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Markup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManageMarkups extends Controller
{
    public function list() {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Promo Codes');
        $data['markups']               = Markup::orderBy('created_at', 'desc')->get();
        
        return view('admin.markups.list', $data);
    }

    public function edit(Request $request) {
        
        $id = $request->id;
        $markupValue = $request->markup;

        $markup = Markup::find($id);
    
        if (!$markup) {
            return redirect()->back()->with('error', trans('msg.admin.Markup not found'));
        }

        $validatedData = $request->validate([
            'markup' => 'required',
        ]);
    
        $markup->markup = $markupValue;
        $update = $markup->save();

        // if ($update) {
        //     return redirect()->route('markup.list')->with('success', trans('msg.admin.Markup updated successfully').'.');
        // } else {
        //     return redirect()->back()->with('error', trans('msg.admin.Failed to update Markup. Please try again').'...');
        // }

        if ($update) {
            return response()->json(['message' => trans('msg.admin.Markup updated successfully').'.']);
        } else {
            return response()->json(['error' => trans('msg.admin.Failed to update Markup. Please try again').'...']);
        }
            
    }
}
