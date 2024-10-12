<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255',
            'category' => 'required|min:3|max:255',
            'price' => 'required|numeric|min:0|max:10000000'
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'name.min' => 'Nama produk minimal :min huruf',
            'name.max' => 'Nama produk maksimal :max huruf',
            'category.required' => 'Kategori wajib diisi',
            'category.min' => 'Kategori minimal :min huruf',
            'category.max' => 'Kategori maksimal :max huruf',
            'price.required' => 'Harga wajib diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga minimal :min',
            'price.max' => 'Harga maksimal :max'
        ]);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            $errorString = implode(', ', $errorMessages);

            return redirect()->back()
                ->with('error', $errorString)
                ->withInput();
        }

        try {
            $product = new Product();
            $product->name = Str::title($request->input('name'));
            $product->category = Str::title($request->input('category'));
            $product->price = $request->input('price');
            $product->save();

            return redirect()->route('products.index')->with('success', 'Berhasil tambah data');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi');
        }
    }

    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('products.edit', ['product' => $product]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi');
        };
    }

    public function update(request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:255',
            'category' => 'required|min:3|max:255',
            'price' => 'required|numeric|min:0|max:10000000'
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'name.min' => 'Nama produk minimal :min huruf',
            'name.max' => 'Nama produk maksimal :max huruf',
            'category.required' => 'Kategori wajib diisi',
            'category.min' => 'Kategori minimal :min huruf',
            'category.max' => 'Kategori maksimal :max huruf',
            'price.required' => 'Harga wajib diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga minimal :min',
            'price.max' => 'Harga maksimal :max'
        ]);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            $errorString = implode(', ', $errorMessages);

            return redirect()->back()
                ->with('error', $errorString)
                ->withInput();
        }

        try {
            $product = Product::findOrFail($id);
            $product->name = Str::title($request->input('name'));
            $product->category = Str::title($request->input('category'));
            $product->price = $request->input('price');
            $product->save();

            return redirect()->route('products.index')->with('success', 'Berhasil ubah data');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi');
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Berhasil hapus data');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan, silakan coba lagi');
        }
    }
}
