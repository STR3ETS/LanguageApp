<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $featured = BlogPost::published()->featured()->with('category')->latest('published_at')->first();
        $posts = BlogPost::published()->where('is_featured', false)->with('category')->latest('published_at')->get();
        $categories = BlogCategory::withCount(['posts' => fn ($q) => $q->published()])->get();

        return view('pages.blog', compact('featured', 'posts', 'categories'));
    }

    public function show(BlogPost $post)
    {
        abort_unless($post->is_published, 404);
        $post->load('category');

        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->where('blog_category_id', $post->blog_category_id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.blog-show', compact('post', 'related'));
    }
}
