@extends('layouts.admin')

@section('title', 'Blog Posts - Admin')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-display text-2xl font-bold text-bright">Blog Posts</h1>
                <p class="text-sm text-muted mt-1">{{ $posts->total() }} posts</p>
            </div>
            <a href="{{ route('admin.blog.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i> New post
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 px-5 py-3 glass-card rounded-xl border-mint/20 text-sm text-mint-light flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="glass-card rounded-2xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-border/30">
                        <th class="text-left p-4 text-muted font-medium text-xs uppercase tracking-widest">Title</th>
                        <th class="text-left p-4 text-muted font-medium text-xs uppercase tracking-widest hidden md:table-cell">Category</th>
                        <th class="text-left p-4 text-muted font-medium text-xs uppercase tracking-widest hidden lg:table-cell">Status</th>
                        <th class="text-left p-4 text-muted font-medium text-xs uppercase tracking-widest hidden lg:table-cell">Date</th>
                        <th class="p-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/20">
                    @foreach($posts as $post)
                        <tr class="hover:bg-elevated/30 transition-colors">
                            <td class="p-4">
                                <div class="font-semibold text-bright">{{ $post->title }}</div>
                                <div class="text-[11px] text-muted mt-0.5 line-clamp-1">{{ $post->excerpt }}</div>
                            </td>
                            <td class="p-4 hidden md:table-cell">
                                <span class="text-[10px] px-2 py-0.5 bg-{{ $post->category->color }}/10 text-{{ $post->category->color }}-light rounded-full font-semibold">{{ $post->category->name }}</span>
                            </td>
                            <td class="p-4 hidden lg:table-cell">
                                @if($post->is_published)
                                    <span class="text-[10px] px-2 py-0.5 bg-mint/10 text-mint-light rounded-full font-semibold">Published</span>
                                @else
                                    <span class="text-[10px] px-2 py-0.5 bg-elevated text-muted rounded-full">Draft</span>
                                @endif
                                @if($post->is_featured)
                                    <span class="text-[10px] px-2 py-0.5 bg-sun/10 text-sun-light rounded-full font-semibold ml-1">Featured</span>
                                @endif
                            </td>
                            <td class="p-4 hidden lg:table-cell text-xs text-muted">{{ $post->published_at?->format('M j, Y') ?? '—' }}</td>
                            <td class="p-4">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route('admin.blog.edit', $post) }}" class="text-xs text-indigo-light hover:text-indigo cursor-pointer">Edit</a>
                                    <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" onsubmit="return confirm('Delete this post?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs text-danger hover:text-danger-light cursor-pointer">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $posts->links() }}</div>
    </div>
</div>
@endsection
