@extends('layouts.app')

@section('title', "Learn {$language->name} - Fluence")

@section('content')

@php
    $lm = config('landmarks.' . $language->slug, ['img' => '', 'place' => '']);
    $heroImg = str_replace(['w=600', 'h=400'], ['w=1400', 'h=600'], $lm['img']);
    $totalLessons = $language->levels->sum(fn($l) => $l->lessons->count());
    $totalLevels = $language->levels->count();

    $cefrMeta = [
        'A1' => ['label' => 'Beginner', 'color' => 'mint', 'icon' => 'fa-seedling'],
        'A2' => ['label' => 'Elementary', 'color' => 'sky', 'icon' => 'fa-leaf'],
        'B1' => ['label' => 'Intermediate', 'color' => 'indigo', 'icon' => 'fa-tree'],
        'B2' => ['label' => 'Upper Intermediate', 'color' => 'sun', 'icon' => 'fa-mountain'],
        'C1' => ['label' => 'Advanced', 'color' => 'rose', 'icon' => 'fa-crown'],
        'C2' => ['label' => 'Mastery', 'color' => 'indigo', 'icon' => 'fa-gem'],
    ];
    $cefrGroups = $language->levels->groupBy('cefr');
@endphp

{{-- ===== HERO ===== --}}
<section class="relative py-24 lg:py-32 overflow-hidden">
    <div class="absolute top-[10%] left-[15%] w-[500px] h-[500px] bg-indigo/5 rounded-full blur-[180px]"></div>
    <div class="absolute bottom-[10%] right-[10%] w-[400px] h-[400px] bg-indigo/3 rounded-full blur-[150px]"></div>
    <div class="absolute inset-0 opacity-[0.015]" style="background-image: radial-gradient(circle, rgba(139,123,245,0.4) 1px, transparent 1px); background-size: 50px 50px;"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div>
                <div class="inline-flex items-center gap-2.5 px-4 py-2 glass rounded-full mb-6">
                    <x-flag :code="$language->flag_code" size="md" />
                    <span class="text-sm font-semibold text-bright">{{ $language->native_name }}</span>
                    <span class="w-1 h-1 rounded-full bg-muted"></span>
                    <span class="text-xs text-muted">{{ $lm['place'] }}</span>
                </div>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-bright mb-5">Learn {{ $language->name }}.</h1>
                <p class="text-lg text-soft mb-8 leading-relaxed">{{ $language->description }}</p>

                <div class="flex flex-wrap items-center gap-3 mb-8">
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-elevated/60 border border-border/20 rounded-full text-xs text-soft">
                        <i class="fa-solid fa-layer-group text-[10px] text-indigo-light"></i> {{ $totalLevels }} levels
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-elevated/60 border border-border/20 rounded-full text-xs text-soft">
                        <i class="fa-solid fa-book text-[10px] text-mint-light"></i> {{ $totalLessons }} lessons
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-elevated/60 border border-border/20 rounded-full text-xs text-soft">
                        <i class="fa-solid fa-signal text-[10px] text-sun-light"></i> A1–C2
                    </div>
                </div>

                @auth
                    @php
                        $hasSubscription = auth()->user()->subscriptions()->where('language_id', $language->id)->where('status', 'active')->exists();
                    @endphp
                    @if($hasSubscription)
                        <a href="{{ route('learn.language', $language->slug) }}" class="group inline-flex items-center gap-3 px-8 py-4 bg-indigo hover:bg-indigo-light text-white font-bold rounded-full transition-all duration-300 hover:shadow-[0_0_40px_var(--color-indigo-glow)] cursor-pointer">
                            <i class="fa-solid fa-play text-xs"></i>
                            Continue learning
                            <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                        </a>
                    @else
                        <form action="{{ route('subscribe', $language) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-8 py-4 bg-indigo hover:bg-indigo-light text-white font-bold rounded-full transition-all duration-300 hover:shadow-[0_0_40px_var(--color-indigo-glow)] cursor-pointer">
                                <i class="fa-solid fa-lock-open text-sm"></i>
                                Start learning {{ $language->name }}
                            </button>
                        </form>
                        <p class="text-sm text-muted mt-3">Free at A1. Premium for all levels.</p>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-indigo hover:bg-indigo-light text-white font-bold rounded-full transition-all duration-300 hover:shadow-[0_0_40px_var(--color-indigo-glow)] cursor-pointer">
                        <i class="fa-solid fa-crown text-sm"></i>
                        Start learning {{ $language->name }}
                    </a>
                    <p class="text-sm text-muted mt-3">Free at A1 level. Premium from &euro;5.99/month.</p>
                @endauth
            </div>

            {{-- Visual: landmark image + floating stats --}}
            <div class="relative">
                <div class="rounded-3xl overflow-hidden aspect-[4/3] relative">
                    <img src="{{ $heroImg }}" alt="{{ $language->name }}" class="w-full h-full object-cover" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-night/40 to-transparent"></div>
                </div>
                {{-- Floating stat cards --}}
                <div class="absolute -bottom-4 -left-4 glass-card rounded-xl p-3 flex items-center gap-2.5 animate-[floatLeft1_14s_ease-in-out_infinite]">
                    <div class="w-8 h-8 bg-mint/15 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-graduation-cap text-mint-light text-xs"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-bright">{{ $totalLessons }}</div>
                        <div class="text-[9px] text-muted">Lessons</div>
                    </div>
                </div>
                <div class="absolute -top-4 -right-4 glass-card rounded-xl p-3 flex items-center gap-2.5 animate-[floatRight1_16s_ease-in-out_infinite]">
                    <div class="w-8 h-8 bg-sun/15 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-bolt text-sun-light text-xs"></i>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-bright">A1–C2</div>
                        <div class="text-[9px] text-muted">All levels</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== WHAT YOU'LL LEARN ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute top-[20%] right-[10%] w-[400px] h-[400px] bg-indigo/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-6">
                    What you'll learn in <span class="text-gradient italic">{{ $language->name }}.</span>
                </h2>
                <p class="text-soft text-base leading-relaxed mb-6">From your first "hello" to fluent conversations. Every level is carefully structured to build on what you've learned before — vocabulary, grammar, listening, and reading combined.</p>
                <p class="text-soft text-base leading-relaxed">Lessons take 3-5 minutes, mix 4 different exercise types, and use spaced repetition to make sure you remember what you learn.</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @foreach([
                    ['icon' => 'fa-comments', 'title' => 'Vocabulary', 'desc' => 'Essential words and phrases for real conversations.', 'color' => 'indigo'],
                    ['icon' => 'fa-spell-check', 'title' => 'Grammar', 'desc' => 'Learn naturally through context, not rules.', 'color' => 'mint'],
                    ['icon' => 'fa-ear-listen', 'title' => 'Listening', 'desc' => 'Native pronunciation and audio exercises.', 'color' => 'sun'],
                    ['icon' => 'fa-book-open', 'title' => 'Reading', 'desc' => 'From simple phrases to complex texts.', 'color' => 'sky'],
                ] as $skill)
                    <div class="glass-card rounded-2xl p-5 group hover:border-{{ $skill['color'] }}/15 transition-all duration-500">
                        <div class="w-10 h-10 bg-{{ $skill['color'] }}/10 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid {{ $skill['icon'] }} text-{{ $skill['color'] }}-light text-sm"></i>
                        </div>
                        <h3 class="font-display font-bold text-bright text-sm mb-1">{{ $skill['title'] }}</h3>
                        <p class="text-xs text-muted leading-relaxed">{{ $skill['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== CEFR LEVEL OVERVIEW ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute bottom-[20%] left-[5%] w-[400px] h-[400px] bg-mint/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-5">
                Your path from beginner to <span class="text-gradient italic">fluent.</span>
            </h2>
            <p class="text-soft text-lg">{{ $language->name }} follows the CEFR framework — 6 levels from A1 to C2. Each level unlocks as you progress.</p>
        </div>

        <div class="max-w-3xl mx-auto space-y-4">
            @foreach($cefrGroups as $cefr => $levels)
                @php
                    $meta = $cefrMeta[$cefr] ?? ['label' => $cefr, 'color' => 'indigo', 'icon' => 'fa-circle'];
                    $cefrLessons = $levels->sum(fn($l) => $l->lessons->count());
                    $cefrLevels = $levels->count();
                    $isFirst = $loop->first;
                @endphp
                <div class="glass-card rounded-2xl p-5 flex items-center gap-5 group hover:border-{{ $meta['color'] }}/15 transition-all duration-500">
                    <div class="w-12 h-12 bg-{{ $meta['color'] }}/10 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fa-solid {{ $meta['icon'] }} text-{{ $meta['color'] }}-light text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <h3 class="font-display font-bold text-bright text-sm">{{ $cefr }} — {{ $meta['label'] }}</h3>
                            @if($isFirst)
                                <span class="text-[9px] px-2 py-0.5 bg-mint/10 text-mint-light rounded-full font-semibold">FREE</span>
                            @else
                                <span class="text-[9px] px-2 py-0.5 bg-indigo/10 text-indigo-light rounded-full font-semibold">PREMIUM</span>
                            @endif
                        </div>
                        <div class="text-xs text-muted">{{ $cefrLevels }} {{ Str::plural('level', $cefrLevels) }} · {{ $cefrLessons }} {{ Str::plural('lesson', $cefrLessons) }}</div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-[10px] text-subtle group-hover:text-{{ $meta['color'] }}-light group-hover:translate-x-0.5 transition-all duration-200"></i>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== LEARNING PATH PREVIEW ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute top-[10%] right-[15%] w-[400px] h-[400px] bg-indigo/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-4xl mx-auto px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
            <h2 class="font-display text-2xl sm:text-3xl font-bold text-bright">Course content</h2>
            <span class="text-xs text-muted">{{ $totalLevels }} levels · {{ $totalLessons }} lessons</span>
        </div>

        <div class="space-y-4">
            @foreach($language->levels->take(6) as $levelIndex => $level)
                @php
                    $colors = ['mint', 'sky', 'indigo', 'sun', 'rose', 'indigo'];
                    $color = $colors[$levelIndex % count($colors)];
                @endphp
                <div class="glass-card rounded-2xl overflow-hidden group hover:border-{{ $color }}/15 transition-all duration-500" x-data="{ open: {{ $levelIndex === 0 ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full px-6 py-5 flex items-center justify-between cursor-pointer hover:bg-elevated/20 transition-colors duration-200 focus:outline-none">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-{{ $color }}/10 rounded-xl flex items-center justify-center shrink-0">
                                <span class="text-xs font-bold text-{{ $color }}-light">{{ $level->number }}</span>
                            </div>
                            <div class="text-left">
                                <h3 class="font-display font-bold text-bright text-sm">{{ $level->name }}</h3>
                                <div class="text-xs text-muted">
                                    @if($level->description){{ $level->description }} · @endif{{ $level->lessons->count() }} lessons · {{ $level->xp_required }} XP
                                </div>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] text-muted transition-transform duration-200" :class="open && 'rotate-180'"></i>
                    </button>

                    <div x-show="open" x-collapse>
                        <div class="border-t border-border/20 divide-y divide-border/15">
                            @foreach($level->lessons as $lessonIndex => $lesson)
                                <div class="px-6 py-3.5 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-7 h-7 bg-elevated rounded-lg flex items-center justify-center">
                                            <span class="text-[10px] font-semibold text-muted">{{ $lessonIndex + 1 }}</span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-text">{{ $lesson->title }}</div>
                                            <div class="text-[11px] text-muted">{{ ucfirst($lesson->type) }}</div>
                                        </div>
                                    </div>
                                    <span class="text-xs text-{{ $color }}-light font-semibold">+{{ $lesson->xp_reward }} XP</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach

            @if($totalLevels > 6)
                <div class="text-center py-4">
                    <span class="text-sm text-muted">+ {{ $totalLevels - 6 }} more levels</span>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- ===== HOW IT WORKS ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute bottom-[10%] right-[10%] w-[400px] h-[400px] bg-sun/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-5">
                How learning {{ $language->name }} <span class="text-gradient italic">works.</span>
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
            @foreach([
                ['num' => '01', 'icon' => 'fa-lock-open', 'title' => 'Start with A1', 'desc' => 'Begin with the basics — greetings, numbers, essential phrases. Free plan includes the full A1 level.', 'color' => 'mint'],
                ['num' => '02', 'icon' => 'fa-pen-nib', 'title' => 'Learn in 5 minutes', 'desc' => 'Complete bite-sized lessons mixing translation, matching, fill-in-the-blank, and listening exercises.', 'color' => 'indigo'],
                ['num' => '03', 'icon' => 'fa-chart-simple', 'title' => 'Level up', 'desc' => 'Earn XP, build your streak, and unlock higher levels. Spaced repetition ensures you remember everything.', 'color' => 'sun'],
            ] as $step)
                <div class="glass-card rounded-2xl p-8 text-center group hover:border-{{ $step['color'] }}/15 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-b from-{{ $step['color'] }}/4 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="text-3xl font-display font-bold text-{{ $step['color'] }}-light opacity-15 mb-3">{{ $step['num'] }}</div>
                        <div class="w-12 h-12 mx-auto bg-{{ $step['color'] }}/10 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid {{ $step['icon'] }} text-{{ $step['color'] }}-light text-lg"></i>
                        </div>
                        <h3 class="font-display font-bold text-bright mb-2">{{ $step['title'] }}</h3>
                        <p class="text-sm text-muted leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== FREE VS PREMIUM ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute top-[20%] left-[30%] w-[500px] h-[500px] bg-indigo/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-4xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight">Start free. <span class="text-gradient italic">Go further.</span></h2>
            <p class="text-soft mt-4">Try {{ $language->name }} at A1 for free. Upgrade for the full experience.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            <div class="glass-card rounded-2xl p-8">
                <div class="text-xs font-semibold text-muted uppercase tracking-widest mb-2">Free</div>
                <div class="text-3xl font-display font-bold text-bright mb-6">&euro;0</div>
                <ul class="space-y-3">
                    @foreach([$language->name . ' at A1 level', 'Basic exercises', 'Streaks & XP tracking', 'No ads'] as $feat)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-indigo-light"></i>{{ $feat }}
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full px-6 py-3.5 glass hover:bg-elevated text-text text-sm font-semibold rounded-full transition-all duration-300 mt-8 cursor-pointer">
                    Start free
                </a>
            </div>
            <div class="glass-card rounded-2xl p-8 border-indigo/20 glow-indigo">
                <div class="text-xs font-semibold text-indigo-light uppercase tracking-widest mb-2">Premium</div>
                <div class="flex items-baseline gap-1 mb-6">
                    <span class="text-3xl font-display font-bold text-bright">&euro;5.99</span>
                    <span class="text-muted text-sm">/ month</span>
                </div>
                <ul class="space-y-3">
                    @foreach(['All 2 languages including ' . $language->name, 'All levels A1 to C2', 'All exercise types & spaced repetition', 'Audio flashcards', 'Priority support'] as $feat)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-indigo-light"></i>{{ $feat }}
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full px-6 py-3.5 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_30px_var(--color-indigo-glow)] mt-8 cursor-pointer">
                    <i class="fa-solid fa-crown text-xs mr-2"></i> Start free trial
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ===== CTA ===== --}}
<section class="relative overflow-hidden py-16 lg:py-20">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo/15 via-surface to-indigo/8 animate-[ctaGradient_8s_ease-in-out_infinite_alternate]"></div>
    <div class="absolute inset-0 bg-gradient-to-tl from-indigo/8 via-transparent to-indigo/10 animate-[ctaGradient2_10s_ease-in-out_infinite_alternate]"></div>
    <div class="absolute top-[10%] left-[10%] w-[500px] h-[500px] bg-indigo/10 rounded-full blur-[180px] animate-[blob1_18s_ease-in-out_infinite]"></div>

    <div class="relative max-w-3xl mx-auto px-6 lg:px-8 text-center">
        <h2 class="font-display text-4xl sm:text-5xl font-bold text-bright tracking-tight mb-5">Start {{ $language->name }} today.</h2>
        <div class="gold-line mx-auto my-6"></div>
        <p class="text-lg text-soft mb-10">Your first lesson is free. No credit card required.</p>
        <a href="{{ route('register') }}" class="group inline-flex items-center justify-center gap-3 px-10 py-4 bg-indigo hover:bg-indigo-light text-white font-bold rounded-full transition-all duration-500 hover:shadow-[0_0_60px_var(--color-indigo-glow)] text-base cursor-pointer">
            Get started free
            <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
        </a>
        <p class="text-xs text-muted mt-5 flex items-center justify-center gap-2">
            <i class="fa-solid fa-shield-check text-indigo-light text-[10px]"></i>
            No credit card required. Cancel anytime.
        </p>
    </div>
</section>
@endsection
