<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:categories|max:255',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.min' => 'Nama kategori harus terdiri dari minimal 3 karakter.',
            'name.unique' => 'Nama kategori sudah ada. Silakan gunakan nama lain.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
        ]);

        $category = new Category();
        $category->name = ucwords($request->input('name'));
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|unique:categories|max:255',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.min' => 'Nama kategori harus terdiri dari minimal 3 karakter.',
            'name.unique' => 'Nama kategori sudah ada. Silakan gunakan nama lain.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
        ]);
        $post = Category::findOrFail($id);

        $post->update([
            'name' => ucwords($request->input('name'))
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $post = Category::findOrFail($id);
        $post->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
