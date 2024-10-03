<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataMaster\M_customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = M_customer::paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function insert(Request $request, M_customer $customer)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|max:15',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $customer->name = $request->post('name');
        $customer->email = $request->post('email');
        $customer->phone = $request->post('phone');
        $customer->save();
        return redirect()->intended(route('admin.customers'));
    }

    public function edit($id)
    {
        $customer = M_customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = M_customer::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|max:15',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $customer->name = $request->post('name');
        $customer->email = $request->post('email');
        $customer->phone = $request->post('phone');
        $customer->save();

        return redirect()->route('admin.customers')->with('success', __('customer updated successfully.'));
    }

    public function destroy($id)
    {
        $customer = M_customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('admin.customers')->with('success', __('customer deleted successfully.'));
    }

    public function show($id)
    {
        $customer = M_customer::findOrFail($id);
        return view('admin.customers.show', ['customer' => $customer]);
    }
}
