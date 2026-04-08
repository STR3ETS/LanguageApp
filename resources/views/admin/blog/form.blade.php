@extends('layouts.admin')

@section('title', ($post ? 'Edit' : 'New') . ' Post - Admin')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-6 lg:px-8">

        <a href="{{ route('admin.blog.index') }}" class="inline-flex items-center gap-2 text-sm text-muted hover:text-indigo-light transition-colors mb-6 cursor-pointer">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to posts
        </a>

        <h1 class="font-display text-2xl font-bold text-bright mb-8">{{ $post ? 'Edit post' : 'New post' }}</h1>

        <form action="{{ $post ? route('admin.blog.update', $post) : route('admin.blog.store') }}" method="POST" class="space-y-6">
            @csrf
            @if($post) @method('PUT') @endif

            <div>
                <label class="block text-xs font-semibold text-soft uppercase tracking-widest mb-2">Title</label>
                <input type="text" name="title" value="{{ old('title', $post?->title) }}" class="w-full px-4 py-3 bg-elevated border border-border/50 rounded-xl text-sm text-text placeholder-muted focus:outline-none focus:border-indigo/40" placeholder="Post title" required>
                @error('title') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-soft uppercase tracking-widest mb-2">Category</label>
                    <select name="blog_category_id" class="w-full px-4 py-3 bg-elevated border border-border/50 rounded-xl text-sm text-text focus:outline-none focus:border-indigo/40" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('blog_category_id', $post?->blog_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-soft uppercase tracking-widest mb-2">Read time</label>
                    <input type="text" name="read_time" value="{{ old('read_time', $post?->read_time ?? '5 min read') }}" class="w-full px-4 py-3 bg-elevated border border-border/50 rounded-xl text-sm text-text focus:outline-none focus:border-indigo/40" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-soft uppercase tracking-widest mb-2">Excerpt</label>
                <textarea name="excerpt" rows="3" class="w-full px-4 py-3 bg-elevated border border-border/50 rounded-xl text-sm text-text placeholder-muted focus:outline-none focus:border-indigo/40 resize-none" placeholder="Short summary..." required>{{ old('excerpt', $post?->excerpt) }}</textarea>
                @error('excerpt') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-soft uppercase tracking-widest mb-2">Body (Markdown)</label>
                <textarea name="body" rows="20" class="w-full px-4 py-3 bg-elevated border border-border/50 rounded-xl text-sm text-text font-mono placeholder-muted focus:outline-none focus:border-indigo/40 resize-y" placeholder="Write your post in Markdown..." required>{{ old('body', $post?->body) }}</textarea>
                @error('body') <p class="text-xs text-danger mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post?->is_published) ? 'checked' : '' }} class="rounded border-border/50 bg-elevated text-indigo focus:ring-indigo/30 cursor-pointer">
                    <span class="text-sm text-soft">Published</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post?->is_featured) ? 'checked' : '' }} class="rounded border-border/50 bg-elevated text-sun focus:ring-sun/30 cursor-pointer">
                    <span class="text-sm text-soft">Featured</span>
                </label>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo hover:bg-indigo-light text-white font-semibold rounded-full transition-all cursor-pointer">
                    <i class="fa-solid fa-check text-xs"></i> {{ $post ? 'Update post' : 'Create post' }}
                </button>
                <a href="{{ route('admin.blog.index') }}" class="px-6 py-3 text-sm text-muted hover:text-bright transition-colors cursor-pointer">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
