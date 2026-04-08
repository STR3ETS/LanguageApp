@extends('layouts.app')

@section('title', 'Languages - Fluence')

@section('content')

@php $landmarks = config('landmarks'); @endphp

<x-page-hero
    title="Choose your"
    highlight="language."
    subtitle="10 languages. From absolute beginner to advanced. Start free with A1 or unlock everything with Premium."
    badge="10 languages available"
    badge-icon="fa-solid fa-globe"
    badge-color="sky"
/>

{{-- ===== LANGUAGE GRID ===== --}}
<section class="py-16 border-t border-border/30 relative overflow-hidden">
    <div class="absolute top-0 left-[20%] w-[500px] h-[500px] bg-indigo/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 max-w-6xl mx-auto">
            @foreach($languages as $language)
                @php $lm = $landmarks[$language->slug] ?? ['img' => '', 'place' => '']; @endphp
                <a href="{{ route('languages.show', $language) }}" class="glass-card rounded-2xl p-5 flex items-center gap-4 group hover:border-indigo/15 transition-all duration-300 cursor-pointer relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-[150px] h-[150px] bg-indigo/3 rounded-full blur-[60px] group-hover:bg-indigo/6 transition-all duration-500"></div>

                    <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0 ring-1 ring-border/20">
                        <img src="{{ $lm['img'] }}" alt="{{ $language->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                    </div>

                    <div class="relative flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <x-flag :code="$language->flag_code" size="sm" />
                            <span class="font-display text-base font-bold text-bright">{{ $language->name }}</span>
                        </div>
                        <div class="text-xs text-muted">{{ $language->native_name }}</div>
                    </div>

                    <i class="fa-solid fa-chevron-right text-[10px] text-subtle group-hover:text-indigo-light group-hover:translate-x-0.5 transition-all duration-200 shrink-0"></i>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== HOW LEVELS WORK ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute bottom-[20%] right-[5%] w-[400px] h-[400px] bg-mint/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-6">
                    From first word to <span class="text-gradient italic">fluent.</span>
                </h2>
                <p class="text-soft text-base leading-relaxed mb-6">Every language follows the CEFR framework — the European standard for language proficiency. You start at A1 (complete beginner) and work your way up through structured levels.</p>
                <p class="text-soft text-base leading-relaxed mb-6">Each level introduces harder vocabulary, more complex grammar, and longer sentences. You earn XP with every exercise and unlock the next level when you're ready.</p>
                <p class="text-soft text-base leading-relaxed">The free plan includes A1 for 1 language. Premium unlocks all levels (A1–C2) for all 10 languages.</p>
            </div>
            <div class="space-y-3">
                @foreach([
                    ['level' => 'A1', 'name' => 'Beginner', 'desc' => 'Basic greetings, numbers, simple phrases. Can introduce yourself.', 'color' => 'mint', 'free' => true],
                    ['level' => 'A2', 'name' => 'Elementary', 'desc' => 'Daily situations, simple conversations, basic grammar.', 'color' => 'sky', 'free' => false],
                    ['level' => 'B1', 'name' => 'Intermediate', 'desc' => 'Travel, work, opinions. Can handle most situations.', 'color' => 'indigo', 'free' => false],
                    ['level' => 'B2', 'name' => 'Upper Intermediate', 'desc' => 'Complex topics, fluent interaction, nuanced expression.', 'color' => 'indigo', 'free' => false],
                    ['level' => 'C1', 'name' => 'Advanced', 'desc' => 'Near-native comprehension. Professional and academic use.', 'color' => 'sun', 'free' => false],
                    ['level' => 'C2', 'name' => 'Mastery', 'desc' => 'Full fluency. Can express yourself effortlessly on any topic.', 'color' => 'rose', 'free' => false],
                ] as $level)
                    <div class="glass-card rounded-2xl p-4 flex items-center gap-4">
                        <div class="w-12 h-12 bg-{{ $level['color'] }}/10 rounded-xl flex items-center justify-center shrink-0">
                            <span class="text-sm font-bold text-{{ $level['color'] }}-light">{{ $level['level'] }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-bright">{{ $level['name'] }}</h3>
                                @if($level['free'])
                                    <span class="text-[9px] px-2 py-0.5 bg-mint/10 text-mint-light rounded-full font-semibold">FREE</span>
                                @else
                                    <span class="text-[9px] px-2 py-0.5 bg-indigo/10 text-indigo-light rounded-full font-semibold">PREMIUM</span>
                                @endif
                            </div>
                            <p class="text-xs text-muted mt-0.5">{{ $level['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== PLANS ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute top-[20%] left-[30%] w-[400px] h-[400px] bg-indigo/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-5xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight">Start free. <span class="text-gradient italic">Go further.</span></h2>
            <p class="text-soft mt-4">A1 is free for one language. Premium unlocks everything.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-5">
            {{-- Free --}}
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-xs font-semibold text-muted uppercase tracking-widest">Free</div>
                    <div class="text-xl font-display font-bold text-bright">&euro;0</div>
                </div>
                <ul class="space-y-2.5">
                    @foreach(['1 language', 'A1 level only', 'Basic exercises', 'Streaks & XP'] as $feat)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-indigo-light"></i>{{ $feat }}
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Premium --}}
            <div class="glass-card rounded-2xl p-6 border-indigo/20 glow-indigo relative">
                <div class="absolute -top-2.5 left-1/2 -translate-x-1/2 px-3 py-0.5 bg-indigo text-white text-[10px] font-semibold rounded-full">Popular</div>
                <div class="flex items-center justify-between mb-4">
                    <div class="text-xs font-semibold text-indigo-light uppercase tracking-widest">Premium</div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-xl font-display font-bold text-bright">&euro;5.99</span>
                        <span class="text-xs text-muted">/mo</span>
                    </div>
                </div>
                <ul class="space-y-2.5">
                    @foreach(['All 10 languages', 'All levels A1–C2', 'All exercise types', 'Spaced repetition', 'Priority support'] as $feat)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-indigo-light"></i>{{ $feat }}
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Family --}}
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="text-xs font-semibold text-sun uppercase tracking-widest">Family</div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-xl font-display font-bold text-bright">&euro;9.99</span>
                        <span class="text-xs text-muted">/mo</span>
                    </div>
                </div>
                <ul class="space-y-2.5">
                    @foreach(['Everything in Premium', 'Up to 3 accounts', 'Individual profiles', 'Shared family streak'] as $feat)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-indigo-light"></i>{{ $feat }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <p class="text-center mt-8">
            <a href="{{ route('pricing') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_20px_var(--color-indigo-glow)] cursor-pointer">
                View all plans <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </p>
    </div>
</section>

{{-- ===== CTA ===== --}}
<section class="relative overflow-hidden py-16 lg:py-20">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo/15 via-surface to-indigo/8"></div>
    <div class="absolute top-[10%] left-[10%] w-[500px] h-[500px] bg-indigo/10 rounded-full blur-[180px]"></div>

    <div class="relative max-w-3xl mx-auto px-6 lg:px-8 text-center">
        <h2 class="font-display text-4xl sm:text-5xl font-bold text-bright tracking-tight mb-5">Pick a language.</h2>
        <div class="gold-line mx-auto my-6"></div>
        <p class="text-lg text-soft mb-10 max-w-xl mx-auto">Your first lesson is free. No credit card, no commitment.</p>
        <a href="{{ route('register') }}" class="group inline-flex items-center justify-center gap-3 px-10 py-4 bg-indigo hover:bg-indigo-light text-white font-bold rounded-full transition-all duration-500 hover:shadow-[0_0_60px_var(--color-indigo-glow)] text-base">
            Start today &mdash; it's free
            <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
        </a>
    </div>
</section>
@endsection
