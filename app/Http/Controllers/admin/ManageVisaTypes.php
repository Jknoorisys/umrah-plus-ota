<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Markup;
use App\Models\VisaCountry;
use App\Models\VisaTypes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManageVisaTypes extends Controller
{
    public function list() {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Visa Types');
        $data['types']               = VisaTypes::with('country')->orderBy('created_at', 'desc')->get();
        
        return view('admin.visa-type.list', $data);
    }

    public function addForm() {
        $data['previous_title']      = trans('msg.admin.Manage Promo Codes');
        $data['url']                 = route('promo-code.list');
        $data['title']               = trans('msg.admin.Add Promo Code');
        $data['countries']           = VisaCountry::where('status', '=', 'active')->orderBy('created_at', 'desc')->get();
        
        return view('admin.promo-codes.add', $data);
    }

    public function add(Request $request) {
        $markup = Markup::where('service', $request->service)->first()->value('markup');

        $validatedData = $request->validate([
            'service' => 'required',
            'start_date' => 'required|date',
            'expire_date' => 'required|date|after:start_date',
            'code' => ['required', 'string', Rule::unique('promo_codes')->where(function ($query) use ($request) {
                return $query->where('service', $request->service);
            })],
            'type' => 'required',
            'max_discount' => 'required|numeric|min:0',
            'min_purchase' => 'required|numeric|min:0',
            'max_usage_per_user' => 'required|numeric|min:0',
            'discount' => ['required', 'numeric', 'min:0'],
        ]);
    
        if ($request->type == 'percentage' && $request->discount >= $markup && $request->discount > 5 ) {
            return redirect()->back()->with('error', trans('msg.admin.Discount can not be greater than 5%').'.')->withInput();
        }

        $insert = VisaTypes::create($validatedData);

        if ($insert) {
            return redirect()->route('promo-code.list')->with('success', trans('msg.admin.Promo code added successfully').'.');
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Failed to add promo code'))->withInput();
        }
    }

    public function editForm($id) {
        $code = VisaTypes::find($id);

        if ($code) {
            $data['previous_title']  = trans('msg.admin.Manage Promo Codes');
            $data['url']             = route('promo-code.list');
            $data['title']           = trans('msg.admin.Edit Promo Code');
            $data['code']            = $code;
            return view('admin.promo-codes.edit', $data);
        } else {
            return response()->json(['error' => trans('msg.admin.Promo Code Not Found')]);
        }
    }

    public function edit(Request $request) {
        
        $id = $request->id;
        $promoCode = VisaTypes::find($id);
    
        if (!$promoCode) {
            return redirect()->back()->with('error', trans('msg.admin.Promo code not found'));
        }

        $validatedData = $request->validate([
            'service' => 'required',
            'start_date' => 'required|date',
            'expire_date' => 'required|date|after:start_date',
            'code' => ['required', 'string', Rule::unique('promo_codes')->ignore($id)->where(function ($query) use ($request) {
                return $query->where('service', $request->service);
            })],
            'type' => 'required',
            'discount' => 'required|numeric|min:0',
            'max_discount' => 'required|numeric|min:0',
            'min_purchase' => 'required|numeric|min:0',
            'max_usage_per_user' => 'required|numeric|min:0',
        ]);
    
        $update = $promoCode->update($validatedData);

        if ($update) {
            return redirect()->route('promo-code.list')->with('success', trans('msg.admin.Promo code updated successfully').'.');
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Failed to update promo code').'.');
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
