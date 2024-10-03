<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataMaster\M_product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = M_product::paginate(10);
        return view('admin.products.index', ["products" => $products]);
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function edit($id)
    {
        $product = M_product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = M_product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'sku' => 'required|max:15|unique:m_products,sku,' . $product->id,
            'price' => 'required|min:0|numeric',
            'stock' => 'required|min:0|integer',
        ]);

        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());

        $product->name = $request->post('name');
        $product->sku = $request->post('sku');
        $product->price = $request->post('price');
        $product->stock = $request->post('stock');
        $product->save();

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }


    public function destroy($id)
    {
        $product = M_product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products')->with('success', __('Product deleted successfully.'));
    }

    public function show($id)
    {
        $product = M_product::findOrFail($id);
        return view('admin.products.show', ['product' => $product]);
    }

    public function insert(Request $request, M_product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'sku' => 'required|max:15|unique:m_products,sku',
            'price' => 'required|min:0|numeric',
            'stock' => 'required|min:0|integer',
        ]);


        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());

        $product->name = $request->post('name');
        $product->sku = $request->post('sku');
        $product->price = $request->post('price');
        $product->stock = $request->post('stock');
        $product->save();
        return redirect()->intended(route('admin.products'));
    }
}
