@extends('layouts.app')

@section('title', 'Blog - Fluence')

@section('content')

<x-page-hero
    title="Tips, stories &"
    highlight="language insights."
    subtitle="Practical advice on language learning, product updates, and stories from our community of learners around the world."
    badge="Blog"
    badge-icon="fa-solid fa-pen-fancy"
/>

{{-- ===== POSTS ===== --}}
<section class="py-16 border-t border-border/30 relative overflow-hidden">
    <div class="absolute top-0 right-[10%] w-[400px] h-[400px] bg-indigo/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">

        {{-- Featured post --}}
        @if($featured)
            <a href="{{ route('blog.show', $featured) }}" class="block glass-card rounded-3xl p-8 lg:p-12 mb-12 relative overflow-hidden group hover:border-indigo/15 transition-all duration-500">
                <div class="absolute top-0 right-0 w-[300px] h-[300px] bg-{{ $featured->category->color }}/5 rounded-full blur-[100px]"></div>
                <div class="relative grid lg:grid-cols-5 gap-8 items-center">
                    <div class="lg:col-span-3">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-{{ $featured->category->color }}/10 rounded-full mb-4 text-[10px] font-semibold text-{{ $featured->category->color }}-light uppercase tracking-widest">
                            <i class="{{ $featured->category->icon }} text-[8px]"></i>
                            {{ $featured->category->name }}
                        </div>
                        <h2 class="font-display text-2xl sm:text-3xl font-bold text-bright tracking-tight mb-4 group-hover:text-indigo-light transition-colors duration-300">{{ $featured->title }}</h2>
                        <p class="text-soft leading-relaxed mb-6">{{ $featured->excerpt }}</p>
                        <div class="flex items-center gap-4">
                            <span class="text-xs text-muted">{{ $featured->published_at->format('M d, Y') }}</span>
                            <span class="text-xs text-muted">{{ $featured->read_time }}</span>
                            <span class="text-xs text-indigo-light font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">Read article <i class="fa-solid fa-arrow-right text-[9px]"></i></span>
                        </div>
                    </div>
                    <div class="lg:col-span-2 glass rounded-2xl p-10 flex items-center justify-center">
                        <i class="{{ $featured->category->icon }} text-{{ $featured->category->color }}-light/15 text-8xl"></i>
                    </div>
                </div>
            </a>
        @endif

        <div x-data="{ active: 'all' }">
            {{-- Categories filter --}}
            <div class="flex flex-wrap gap-2 mb-10">
                <button @click="active = 'all'" :class="active === 'all' ? 'bg-indigo text-white border-indigo' : 'bg-elevated/50 text-soft hover:text-bright border-border/30'" class="px-4 py-2 rounded-full text-xs font-medium transition-all duration-200 focus:outline-none border cursor-pointer">All</button>
                @foreach($categories as $cat)
                    <button @click="active = '{{ $cat->slug }}'" :class="active === '{{ $cat->slug }}' ? 'bg-indigo text-white border-indigo' : 'bg-elevated/50 text-soft hover:text-bright border-border/30'" class="px-4 py-2 rounded-full text-xs font-medium transition-all duration-200 focus:outline-none border cursor-pointer">{{ $cat->name }}</button>
                @endforeach
            </div>

            {{-- Grid --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($posts as $post)
                    <a href="{{ route('blog.show', $post) }}" x-show="active === 'all' || active === '{{ $post->category->slug }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="glass-card rounded-2xl p-6 group hover:border-{{ $post->category->color }}/15 transition-all duration-500 flex flex-col">
                        <div class="flex items-center justify-between mb-4">
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-{{ $post->category->color }}/10 rounded-full text-[10px] font-semibold text-{{ $post->category->color }}-light uppercase tracking-widest">
                                <i class="{{ $post->category->icon }} text-[8px]"></i>
                                {{ $post->category->name }}
                            </div>
                            <span class="text-[10px] text-muted">{{ $post->read_time }}</span>
                        </div>
                        <h3 class="font-display text-lg font-bold text-bright mb-3 group-hover:text-indigo-light transition-colors duration-300">{{ $post->title }}</h3>
                        <p class="text-sm text-muted leading-relaxed mb-5 flex-1">{{ $post->excerpt }}</p>
                        <div class="flex items-center justify-between pt-4 border-t border-border/20">
                            <span class="text-xs text-muted">{{ $post->published_at->format('M d, Y') }}</span>
                            <span class="text-xs text-indigo-light font-semibold flex items-center gap-1 group-hover:gap-2 transition-all">Read <i class="fa-solid fa-arrow-right text-[9px]"></i></span>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Empty state --}}
            <div x-show="document.querySelectorAll('[x-show*=active]').length === 0" class="text-center py-12 text-muted text-sm" x-cloak>
                No posts in this category yet.
            </div>
        </div>
    </div>
</section>

{{-- ===== NEWSLETTER ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo/8 via-surface to-indigo/5"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center max-w-5xl mx-auto">
            <div>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-4">Stay in the <span class="text-gradient italic">loop.</span></h2>
                <p class="text-soft text-base leading-relaxed mb-4">Language tips, learning science, product updates, and community stories. One email per week, no spam, unsubscribe anytime.</p>
                <ul class="space-y-2">
                    @foreach(['Weekly language learning tips', 'New feature announcements', 'Community stories & motivation', 'Exclusive content for subscribers'] as $item)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-indigo-light"></i>{{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="glass-card rounded-3xl p-8">
                <h3 class="font-display text-xl font-bold text-bright mb-4">Subscribe to our newsletter</h3>
                <form class="space-y-4">
                    <input type="text" placeholder="Your name" class="w-full px-4 py-3 bg-elevated border border-border/50 rounded-xl text-sm text-text placeholder-muted focus:outline-none focus:border-indigo/40 transition-colors duration-200">
                    <input type="email" placeholder="Your email address" class="w-full px-4 py-3 bg-elevated border border-border/50 rounded-xl text-sm text-text placeholder-muted focus:outline-none focus:border-indigo/40 transition-colors duration-200">
                    <button type="submit" class="w-full px-6 py-3 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_20px_var(--color-indigo-glow)]">Subscribe</button>
                    <p class="text-[11px] text-muted text-center">We respect your inbox. Unsubscribe anytime.</p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
