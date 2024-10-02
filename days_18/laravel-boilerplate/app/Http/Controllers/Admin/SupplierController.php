<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataMaster\M_supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = M_supplier::paginate(10);
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function insert(Request $request, M_supplier $supplier)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'contact_person' => 'required|email|max:100',
            'email' => 'required|email|max:100|unique:m_suppliers,email',
            'phone' => 'required|max:15|unique:m_suppliers,phone',
            'address' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $supplier->name = $request->post('name');
        $supplier->contact_person = $request->post('contact_person');
        $supplier->email = $request->post('email');
        $supplier->phone = $request->post('phone');
        $supplier->address = $request->post('address');
        $supplier->save();
        return redirect()->intended(route('admin.suppliers'));
    }

    public function edit($id)
    {
        $supplier = M_supplier::findOrFail($id);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = M_supplier::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'contact_person' => 'required|email|max:100',
            'email' => 'required|email|max:100|unique:m_suppliers,email,' . $supplier->id,
            'phone' => 'required|max:15|unique:m_suppliers,phone,' . $supplier->id,
            'address' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $supplier->name = $request->post('name');
        $supplier->contact_person = $request->post('contact_person');
        $supplier->email = $request->post('email');
        $supplier->phone = $request->post('phone');
        $supplier->address = $request->post('address');
        $supplier->save();

        return redirect()->route('admin.suppliers')->with('success', __('Supplier updated successfully.'));
    }

    public function destroy($id)
    {
        $supplier = M_supplier::findOrFail($id);
        $supplier->delete();
        return redirect()->route('admin.suppliers')->with('success', __('Supplier deleted successfully.'));
    }

    public function show($id)
    {
        $supplier = M_supplier::findOrFail($id);
        return view('admin.suppliers.show', ['supplier' => $supplier]);
    }
}
