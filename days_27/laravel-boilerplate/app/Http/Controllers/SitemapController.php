<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = cache()->remember('sitemap_urls', 3600, function () {
            $urls = [url('/posts')];
            $posts = Post::all();

            foreach ($posts as $post) {
                $urls[] = url('/posts/show/' . $post->id);
            }

            return $urls;
        });

        return response()->view('sitemap.index', ['urls' => $urls], 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
