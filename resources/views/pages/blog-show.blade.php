@extends('layouts.app')

@section('title', $post->title . ' - Fluence Blog')

@section('content')

{{-- Hero --}}
<section class="relative py-24 lg:py-32 overflow-hidden">
    <div class="absolute top-[10%] left-[20%] w-[500px] h-[500px] bg-{{ $post->category->color }}/4 rounded-full blur-[180px]"></div>
    <div class="absolute inset-0 opacity-[0.015]" style="background-image: radial-gradient(circle, rgba(139,123,245,0.4) 1px, transparent 1px); background-size: 50px 50px;"></div>

    <div class="relative max-w-3xl mx-auto px-6 lg:px-8">
        <a href="{{ route('blog') }}" class="inline-flex items-center gap-2 text-sm text-muted hover:text-indigo-light transition-colors duration-200 mb-8">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to blog
        </a>

        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-{{ $post->category->color }}/10 rounded-full mb-6 text-[10px] font-semibold text-{{ $post->category->color }}-light uppercase tracking-widest">
            <i class="{{ $post->category->icon }} text-[8px]"></i>
            {{ $post->category->name }}
        </div>

        <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-bright tracking-tight mb-6 leading-tight">{{ $post->title }}</h1>

        <p class="text-lg text-soft leading-relaxed mb-8">{{ $post->excerpt }}</p>

        <div class="flex items-center gap-4 text-sm text-muted">
            <span>{{ $post->published_at->format('M d, Y') }}</span>
            <span>&middot;</span>
            <span>{{ $post->read_time }}</span>
        </div>

        <div class="gold-line mt-8"></div>
    </div>
</section>

{{-- Article body --}}
<section class="pb-24 lg:pb-32">
    <div class="max-w-3xl mx-auto px-6 lg:px-8">
        <article class="prose-fluence">
            {!! Str::markdown($post->body) !!}
        </article>
    </div>
</section>

{{-- Related posts --}}
@if($related->isNotEmpty())
    <section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
        <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
            <h2 class="font-display text-2xl font-bold text-bright mb-10">More from <span class="text-{{ $post->category->color }}-light">{{ $post->category->name }}</span></h2>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($related as $relPost)
                    <a href="{{ route('blog.show', $relPost) }}" class="glass-card rounded-2xl p-6 group hover:border-{{ $relPost->category->color }}/15 transition-all duration-500 flex flex-col">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-{{ $relPost->category->color }}/10 rounded-full mb-4 text-[10px] font-semibold text-{{ $relPost->category->color }}-light uppercase tracking-widest self-start">
                            <i class="{{ $relPost->category->icon }} text-[8px]"></i>
                            {{ $relPost->category->name }}
                        </div>
                        <h3 class="font-display text-lg font-bold text-bright mb-3 group-hover:text-indigo-light transition-colors duration-300">{{ $relPost->title }}</h3>
                        <p class="text-sm text-muted leading-relaxed mb-4 flex-1 line-clamp-3">{{ $relPost->excerpt }}</p>
                        <div class="flex items-center justify-between pt-4 border-t border-border/20">
                            <span class="text-xs text-muted">{{ $relPost->published_at->format('M d, Y') }}</span>
                            <span class="text-xs text-indigo-light font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">Read <i class="fa-solid fa-arrow-right text-[9px]"></i></span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

{{-- CTA --}}
<section class="relative overflow-hidden py-16 lg:py-20">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo/15 via-surface to-indigo/8"></div>
    <div class="absolute top-[10%] left-[10%] w-[500px] h-[500px] bg-indigo/10 rounded-full blur-[180px]"></div>

    <div class="relative max-w-3xl mx-auto px-6 lg:px-8 text-center">
        <h2 class="font-display text-4xl sm:text-5xl font-bold text-bright tracking-tight mb-5">Ready to start learning?</h2>
        <div class="gold-line mx-auto my-6"></div>
        <p class="text-lg text-soft mb-10">Put these insights into practice. Start your first lesson today.</p>
        <a href="{{ route('register') }}" class="group inline-flex items-center justify-center gap-3 px-10 py-4 bg-indigo hover:bg-indigo-light text-white font-bold rounded-full transition-all duration-500 hover:shadow-[0_0_60px_var(--color-indigo-glow)] text-base">
            Start today &mdash; it's free
            <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
        </a>
    </div>
</section>
@endsection
