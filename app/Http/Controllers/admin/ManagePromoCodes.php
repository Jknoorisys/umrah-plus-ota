<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCodes;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManagePromoCodes extends Controller
{
    public function list() {
        $data['previous_title']      = trans('msg.admin.Dashboard');
        $data['url']                 = route('dashboard');
        $data['title']               = trans('msg.admin.Manage Promo Codes');
        $data['codes']               = PromoCodes::all();
        
        return view('admin.promo-codes.list', $data);
    }

    public function addForm() {
        $data['previous_title']      = trans('msg.admin.Manage Promo Codes');
        $data['url']                 = route('promo-code.list');
        $data['title']               = trans('msg.admin.Add Promo Code');
        
        return view('admin.promo-codes.add', $data);
    }

    public function add(Request $request) {
        $validatedData = $request->validate([
            'service' => 'required',
            'start_date' => 'required|date',
            'expire_date' => 'required|date|after:start_date',
            'code' => ['required', 'string', Rule::unique('promo_codes')->where(function ($query) use ($request) {
                return $query->where('service', $request->service);
            })],
            'type' => 'required',
            'discount' => 'required|numeric|min:0',
            'max_discount' => 'required|numeric|min:0',
            'min_purchase' => 'required|numeric|min:0',
            'max_usage_per_user' => 'required|numeric|min:0',
        ]);

        $insert = PromoCodes::create($validatedData);

        if ($insert) {
            return redirect()->back()->with('success', trans('msg.admin.Promo code added successfully').'.');
        } else {
            return redirect()->back()->with('error', trans('msg.admin.Failed to add promo code. Please try again').'...')->withInput();
        }
    }
}
