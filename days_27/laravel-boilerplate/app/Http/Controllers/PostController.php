<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $posts = Post::with('category')
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('title', 'like', '%' . $query . '%')
                    ->orWhere('content', 'like', '%' . $query . '%');
            })
            ->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:100',
            'content' => 'required|min:100|string',
            'category_id' => 'required|exists:categories,id'
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.min' => 'Judul harus memiliki minimal 5 karakter.',
            'title.max' => 'Judul tidak boleh lebih dari 100 karakter.',
            'content.required' => 'Konten harus diisi.',
            'content.min' => 'Konten harus memiliki minimal 100 karakter.',
            'category_id.required' => 'Kategori harus dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
        ]);

        Post::create($validated);
        return redirect()->route('posts.index');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();

        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|min:5|max:100',
            'content' => 'required|min:100|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $post = Post::findOrFail($id);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('posts.index')->with('success', 'Postingan berhasil diperbarui.');
    }

    public function show($id)
    {
        $post = Post::with(['category', 'comments.user'])->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post berhasil dihapus.');
    }
}
