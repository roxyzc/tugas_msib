<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Artesaos\SEOTools\Facades\SEOMeta;
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
            'meta_description' => 'required|string|max:160',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string'
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.min' => 'Judul harus memiliki minimal :min karakter.',
            'title.max' => 'Judul tidak boleh lebih dari :max karakter.',
            'content.required' => 'Konten harus diisi.',
            'content.min' => 'Konten harus memiliki minimal :min karakter.',
            'meta_description.required' => 'Deskripsi harus diisi.',
            'meta_description.max' => 'Deskripsi tidak boleh lebih dari :max karakter.',
            'category_id.required' => 'Kategori harus dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'tags.string' => 'Tags harus berupa string.',
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'meta_description' => $validated['meta_description'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id(),
        ]);

        if (!empty($request->tags)) {
            $tags = array_map('trim', explode(',', $request->tags));

            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $post->tags()->attach($tag->id);
            }

            SEOMeta::setKeywords($tags);
        }

        SEOMeta::setTitle($request->title);
        SEOMeta::setDescription($post->meta_description);

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
            'meta_description' => 'required|string|max:160',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|string'
        ], [
            'title.required' => 'Judul harus diisi.',
            'title.min' => 'Judul harus memiliki minimal :min karakter.',
            'title.max' => 'Judul tidak boleh lebih dari :max karakter.',
            'content.required' => 'Konten harus diisi.',
            'content.min' => 'Konten harus memiliki minimal :min karakter.',
            'meta_description.required' => 'Deskripsi harus diisi.',
            'meta_description.max' => 'Deskripsi tidak boleh lebih dari :max karakter.',
            'category_id.required' => 'Kategori harus dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'tags.string' => 'Tags harus berupa string.',
        ]);

        $post = Post::findOrFail($id);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'meta_description' => $request->meta_description,
            'category_id' => $request->category_id,
        ]);

        if (!empty($request->tags)) {
            $tags = array_map('trim', explode(',', $request->tags));
            $post->tags()->detach();
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => ucwords($tagName)]);
                $post->tags()->attach($tag->id);
            }

            SEOMeta::setKeywords($tags);
        } else {
            $post->tags()->detach();
        }

        SEOMeta::setTitle('Edit: ' . $post->title);
        SEOMeta::setDescription($post->meta_description);

        return redirect()->route('posts.index')->with('success', 'Postingan berhasil diperbarui.');
    }

    public function show($id)
    {
        $post = Post::with(['category', 'comments.user'])->findOrFail($id);

        SEOMeta::setTitle($post->title);
        SEOMeta::setDescription($post->meta_description);

        return view('posts.show', compact('post'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post berhasil dihapus.');
    }
}
