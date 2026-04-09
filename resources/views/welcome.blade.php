@extends('layouts.app')

@section('title', 'Fluence - The Art of Language')

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative flex items-center overflow-hidden" style="max-height: 700px; height: 100vh;">
    <div class="absolute inset-0">
        <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(circle, rgba(139,123,245,0.5) 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-32 lg:py-40 w-full">

        {{-- Floating question cards — hidden on mobile --}}
        <div class="hidden lg:block">

            {{-- LEFT SIDE --}}

            {{-- French translate --}}
            <div class="absolute left-[2%] top-[18%] glass-card rounded-2xl p-4 w-52 animate-[floatLeft1_14s_ease-in-out_infinite] opacity-70 hover:opacity-100 transition-opacity duration-500">
                <div class="text-[10px] font-semibold uppercase tracking-widest text-indigo-light mb-2">Translate to English</div>
                <div class="text-lg font-display font-bold text-bright mb-3 italic">bonjour</div>
                <div class="space-y-1.5">
                    <div class="px-3 py-2 bg-indigo/10 border border-indigo/20 rounded-lg text-[11px] text-bright font-medium flex items-center justify-between">
                        hello <i class="fa-solid fa-circle-check text-indigo-light text-[9px]"></i>
                    </div>
                    <div class="px-3 py-2 bg-elevated border border-border rounded-lg text-[11px] text-muted">goodbye</div>
                    <div class="px-3 py-2 bg-elevated border border-border rounded-lg text-[11px] text-muted">please</div>
                </div>
            </div>

            {{-- Spanish fill in the blank --}}
            <div class="absolute left-[5%] bottom-[22%] glass-card rounded-2xl p-4 w-52 animate-[floatLeft2_16s_ease-in-out_infinite] opacity-60 hover:opacity-100 transition-opacity duration-500">
                <div class="text-[10px] font-semibold uppercase tracking-widest text-indigo-light mb-2">Fill in the blank</div>
                <div class="text-sm text-soft mb-3">Yo <span class="inline-block border-b border-indigo/40 px-2 text-indigo-light font-semibold">tengo</span> un gato.</div>
                <div class="flex gap-1.5">
                    <div class="px-2.5 py-1.5 bg-indigo/10 border border-indigo/20 rounded-lg text-[10px] text-bright font-medium">tengo</div>
                    <div class="px-2.5 py-1.5 bg-elevated border border-border rounded-lg text-[10px] text-muted">tiene</div>
                    <div class="px-2.5 py-1.5 bg-elevated border border-border rounded-lg text-[10px] text-muted">tienes</div>
                </div>
            </div>

            {{-- German word match --}}
            <div class="absolute left-[8%] top-[52%] glass-card rounded-2xl p-3 w-44 animate-[floatLeft3_17s_ease-in-out_infinite] opacity-50 hover:opacity-100 transition-opacity duration-500">
                <div class="text-[10px] font-semibold uppercase tracking-widest text-indigo-light mb-2">Match the pair</div>
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between text-[10px]">
                        <span class="px-2 py-1 bg-indigo/10 border border-indigo/20 rounded text-bright">Hund</span>
                        <span class="text-muted/40">—</span>
                        <span class="px-2 py-1 bg-indigo/10 border border-indigo/20 rounded text-bright">dog</span>
                    </div>
                    <div class="flex items-center justify-between text-[10px]">
                        <span class="px-2 py-1 bg-elevated border border-border rounded text-muted">Katze</span>
                        <span class="text-muted/40">—</span>
                        <span class="px-2 py-1 bg-elevated border border-border rounded text-muted">?</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDE --}}

            {{-- Italian multiple choice --}}
            <div class="absolute right-[2%] top-[15%] glass-card rounded-2xl p-4 w-52 animate-[floatRight1_15s_ease-in-out_infinite] opacity-70 hover:opacity-100 transition-opacity duration-500">
                <div class="text-[10px] font-semibold uppercase tracking-widest text-indigo-light mb-2">What does this mean?</div>
                <div class="text-lg font-display font-bold text-bright mb-3 italic">grazie</div>
                <div class="space-y-1.5">
                    <div class="px-3 py-2 bg-elevated border border-border rounded-lg text-[11px] text-muted">sorry</div>
                    <div class="px-3 py-2 bg-indigo/10 border border-indigo/20 rounded-lg text-[11px] text-bright font-medium flex items-center justify-between">
                        thank you <i class="fa-solid fa-circle-check text-indigo-light text-[9px]"></i>
                    </div>
                    <div class="px-3 py-2 bg-elevated border border-border rounded-lg text-[11px] text-muted">hello</div>
                </div>
            </div>

            {{-- Japanese listening --}}
            <div class="absolute right-[6%] bottom-[20%] glass-card rounded-2xl p-4 w-48 animate-[floatRight2_18s_ease-in-out_infinite] opacity-60 hover:opacity-100 transition-opacity duration-500">
                <div class="text-[10px] font-semibold uppercase tracking-widest text-indigo-light mb-2">What do you hear?</div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 rounded-full bg-indigo/15 flex items-center justify-center">
                        <i class="fa-solid fa-volume-high text-indigo-light text-[10px]"></i>
                    </div>
                    <div class="text-lg font-display font-bold text-bright">ありがとう</div>
                </div>
                <div class="space-y-1.5">
                    <div class="px-3 py-2 bg-indigo/10 border border-indigo/20 rounded-lg text-[11px] text-bright font-medium flex items-center justify-between">
                        arigatou <i class="fa-solid fa-circle-check text-indigo-light text-[9px]"></i>
                    </div>
                    <div class="px-3 py-2 bg-elevated border border-border rounded-lg text-[11px] text-muted">sayonara</div>
                </div>
            </div>

        </div>

        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center gap-2.5 px-5 py-2.5 glass rounded-full mb-4 group cursor-default">
                <span class="w-1.5 h-1.5 bg-indigo rounded-full animate-pulse"></span>
                <span class="text-[11px] font-medium text-soft tracking-widest uppercase">Premium language learning</span>
            </div>

            <h1 class="font-display text-4xl sm:text-5xl lg:text-7xl font-bold tracking-tight leading-[0.95] mb-8">
                <span class="text-bright">Master the</span><br>
                <span class="text-gradient italic">art of language.</span>
            </h1>

            <div class="gold-line mx-auto my-8"></div>

            <p class="text-lg sm:text-xl text-soft max-w-xl mx-auto mb-14 leading-relaxed">
                Elegant lessons. Effortless progress. A refined experience designed for those who value excellence.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="group inline-flex items-center justify-center gap-3 px-10 py-4 bg-indigo hover:bg-indigo-light text-white font-semibold rounded-full transition-all duration-500 hover:shadow-[0_0_60px_var(--color-indigo-glow)] text-base">
                    Begin your journey
                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                </a>
                <a href="{{ route('how-it-works') }}" class="inline-flex items-center justify-center gap-2 px-10 py-4 glass hover:bg-elevated text-text font-medium rounded-full transition-all duration-300 text-base">
                    <i class="fa-solid fa-play text-xs text-indigo-light"></i>
                    Discover how
                </a>
            </div>

            {{-- Social proof --}}
            <div class="mt-20 flex items-center justify-center gap-6 text-muted">
                <div class="flex -space-x-2">
                    @for($i = 0; $i < 5; $i++)
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo/30 to-sun/20 border-2 border-night flex items-center justify-center">
                            <i class="fa-solid fa-user text-[8px] text-bright/40"></i>
                        </div>
                    @endfor
                </div>
                <span class="text-xs tracking-wide">Trusted by <span class="text-indigo-light font-semibold">2,400+</span> learners</span>
            </div>
        </div>
    </div>

    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-muted/40 animate-bounce">
        <i class="fa-solid fa-chevron-down text-xs"></i>
    </div>
</section>

{{-- ===== HOW IT WORKS ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative">
    <div class="absolute bottom-0 left-[10%] w-[500px] h-[500px] bg-indigo/3 rounded-full blur-[160px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center flex items-center justify-between mx-auto mb-20">
            <h2 class="font-display text-4xl sm:text-5xl font-bold text-bright tracking-tight">Three simple steps. <span class="text-gradient italic">That's all.</span></h2>
            <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full text-xs font-medium text-soft tracking-widest uppercase">
                <i class="fa-solid fa-wand-magic-sparkles text-indigo-light"></i>
                How it works
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6 mx-auto">
            @foreach([
                ['num' => '01', 'icon' => 'fa-lock-open', 'title' => 'Choose your language', 'desc' => 'Select from 2 languages. All included with Premium. Begin with a complimentary trial.', 'color' => 'indigo'],
                ['num' => '02', 'icon' => 'fa-pen-nib', 'title' => 'Learn & practice', 'desc' => 'Complete refined lessons in just 5 minutes. Match, translate, and advance.', 'color' => 'mint'],
                ['num' => '03', 'icon' => 'fa-chart-simple', 'title' => 'Watch yourself grow', 'desc' => 'Track your XP, build streaks, and unlock new levels every day.', 'color' => 'sun'],
            ] as $step)
                <div class="glass-card rounded-3xl p-8 text-center group hover:border-{{ $step['color'] }}/15 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-b from-{{ $step['color'] }}/4 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative">
                        <div class="text-4xl font-display font-bold text-{{ $step['color'] }}-light opacity-20 mb-4">{{ $step['num'] }}</div>
                        <div class="w-14 h-14 mx-auto bg-{{ $step['color'] }}/10 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                            <i class="fa-solid {{ $step['icon'] }} text-{{ $step['color'] }}-light text-xl"></i>
                        </div>
                        <h3 class="text-lg font-display font-bold text-bright mb-2">{{ $step['title'] }}</h3>
                        <p class="text-sm text-muted leading-relaxed">{!! $step['desc'] !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== APP PREVIEW BENTO ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute bottom-0 right-[5%] w-[400px] h-[400px] bg-indigo/4 rounded-full blur-[160px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-14">
            <div class="md:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full mb-6 text-xs font-medium text-soft tracking-widest uppercase">
                    <i class="fa-solid fa-mobile-screen text-indigo-light text-[10px]"></i>
                    Inside the app
                </div>
                <h2 class="font-display text-4xl sm:text-5xl font-bold text-bright tracking-tight">
                    A look at what<br><span class="text-gradient italic">you'll experience.</span>
                </h2>
            </div>
            <p class="text-soft text-base max-w-sm leading-relaxed">Every screen is designed to keep you focused, motivated, and making progress.</p>
        </div>

        {{-- Bento grid 2x2 with varying heights --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Lesson screen — tall --}}
            <div class="lg:col-span-2 lg:row-span-2 glass-card rounded-3xl p-8 relative overflow-hidden group hover:border-indigo/15 transition-all duration-500 min-h-[380px] flex flex-col justify-end">
                <div class="absolute inset-0 bg-gradient-to-t from-night/90 via-night/40 to-transparent z-10"></div>
                {{-- Simulated lesson UI --}}
                <div class="absolute top-6 left-6 right-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-indigo/15 flex items-center justify-center">
                                <span class="text-sm">🇫🇷</span>
                            </div>
                            <span class="text-xs font-semibold text-soft">French · A1</span>
                        </div>
                        <div class="flex items-center gap-1 text-indigo-light text-xs font-semibold">
                            <i class="fa-solid fa-bolt text-[10px]"></i> +15 XP
                        </div>
                    </div>
                    <div class="w-full bg-elevated rounded-full h-1.5 mb-8">
                        <div class="bg-gradient-to-r from-indigo to-indigo-light rounded-full h-1.5 w-[60%] transition-all"></div>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-muted uppercase tracking-widest mb-3">Translate this sentence</p>
                        <p class="text-2xl font-display font-bold text-bright italic mb-6">"Je suis content"</p>
                        <div class="space-y-2 max-w-xs mx-auto">
                            <div class="px-4 py-3 bg-elevated border border-border rounded-xl text-sm text-muted text-left">I am hungry</div>
                            <div class="px-4 py-3 bg-indigo/10 border border-indigo/25 rounded-xl text-sm text-bright font-medium text-left flex justify-between items-center">I am happy <i class="fa-solid fa-circle-check text-indigo-light text-xs"></i></div>
                            <div class="px-4 py-3 bg-elevated border border-border rounded-xl text-sm text-muted text-left">I am tired</div>
                        </div>
                    </div>
                </div>
                <div class="relative z-20">
                    <h3 class="font-display text-xl font-bold text-bright mb-1">Interactive Lessons</h3>
                    <p class="text-sm text-muted">Bite-sized exercises that adapt to your level.</p>
                </div>
            </div>

            {{-- Dashboard preview --}}
            <div class="glass-card rounded-3xl p-6 relative overflow-hidden group hover:border-sky/15 transition-all duration-500">
                <div class="flex items-center gap-2 text-sky-light mb-4">
                    <i class="fa-solid fa-chart-pie text-sm"></i>
                    <span class="text-[10px] font-semibold uppercase tracking-widest">Dashboard</span>
                </div>
                <div class="grid grid-cols-2 gap-2 mb-3">
                    <div class="bg-elevated rounded-xl p-3 text-center">
                        <div class="text-xl font-display font-bold text-bright">12</div>
                        <div class="text-[9px] text-muted">Day streak</div>
                    </div>
                    <div class="bg-elevated rounded-xl p-3 text-center">
                        <div class="text-xl font-display font-bold text-bright">2.4k</div>
                        <div class="text-[9px] text-muted">Total XP</div>
                    </div>
                </div>
                <div class="flex items-end gap-1 h-16">
                    @foreach([30, 45, 35, 60, 55, 80, 50] as $h)
                        <div class="flex-1 bg-sky/15 hover:bg-sky/25 rounded transition-all" style="height: {{ $h }}%"></div>
                    @endforeach
                </div>
            </div>

            {{-- Streak visual --}}
            <div class="glass-card rounded-3xl p-6 relative overflow-hidden group hover:border-sun/15 transition-all duration-500">
                <div class="flex items-center gap-2 text-sun-light mb-4">
                    <i class="fa-solid fa-fire-flame-curved text-sm"></i>
                    <span class="text-[10px] font-semibold uppercase tracking-widest">Streaks</span>
                </div>
                <div class="text-center mb-3">
                    <div class="text-4xl font-display font-bold text-bright mb-1">12</div>
                    <div class="text-xs text-muted">days in a row</div>
                </div>
                <div class="flex justify-center gap-1.5">
                    @foreach(['M','T','W','T','F','S','S'] as $i => $d)
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-7 h-7 rounded-lg {{ $i < 5 ? 'bg-sun/20 border border-sun/30' : 'bg-elevated border border-border' }} flex items-center justify-center">
                                @if($i < 5)<i class="fa-solid fa-check text-[7px] text-sun-light"></i>@endif
                            </div>
                            <span class="text-[8px] text-muted">{{ $d }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Flashcards --}}
            <div class="glass-card rounded-3xl p-6 relative overflow-hidden group hover:border-mint/15 transition-all duration-500">
                <div class="flex items-center gap-2 text-mint-light mb-4">
                    <i class="fa-solid fa-layer-group text-sm"></i>
                    <span class="text-[10px] font-semibold uppercase tracking-widest">Flashcards</span>
                </div>
                <div class="relative">
                    <div class="absolute top-2 left-2 right-2 h-20 bg-elevated/50 rounded-xl border border-border/50 -rotate-2"></div>
                    <div class="absolute top-1 left-1 right-1 h-20 bg-elevated/70 rounded-xl border border-border/50 rotate-1"></div>
                    <div class="relative bg-surface rounded-xl border border-border p-4 text-center">
                        <div class="text-xl font-display font-bold text-bright mb-1 italic">la maison</div>
                        <div class="gold-line mx-auto my-2"></div>
                        <div class="text-sm text-mint-light font-medium">the house</div>
                    </div>
                </div>
                <div class="flex items-center justify-center gap-4 mt-3">
                    <div class="w-8 h-8 rounded-full bg-rose/10 flex items-center justify-center"><i class="fa-solid fa-xmark text-rose text-xs"></i></div>
                    <div class="w-8 h-8 rounded-full bg-mint/15 flex items-center justify-center"><i class="fa-solid fa-check text-mint-light text-xs"></i></div>
                </div>
            </div>

            {{-- Achievements --}}
            <div class="glass-card rounded-3xl p-6 relative overflow-hidden group hover:border-rose/15 transition-all duration-500">
                <div class="flex items-center gap-2 text-sun-light mb-4">
                    <i class="fa-solid fa-trophy text-sm"></i>
                    <span class="text-[10px] font-semibold uppercase tracking-widest">Achievements</span>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    @foreach([
                        ['icon' => 'fa-medal', 'unlocked' => true, 'color' => 'sun'],
                        ['icon' => 'fa-fire', 'unlocked' => true, 'color' => 'rose'],
                        ['icon' => 'fa-bolt', 'unlocked' => true, 'color' => 'indigo'],
                        ['icon' => 'fa-star', 'unlocked' => false, 'color' => 'muted'],
                        ['icon' => 'fa-crown', 'unlocked' => false, 'color' => 'muted'],
                        ['icon' => 'fa-gem', 'unlocked' => false, 'color' => 'muted'],
                    ] as $badge)
                        <div class="aspect-square rounded-xl {{ $badge['unlocked'] ? 'bg-' . $badge['color'] . '/10 border border-' . $badge['color'] . '/20' : 'bg-elevated border border-border opacity-40' }} flex items-center justify-center">
                            <i class="fa-solid {{ $badge['icon'] }} {{ $badge['unlocked'] ? 'text-' . $badge['color'] . '-light' : 'text-muted' }} text-lg"></i>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== FEATURES ALTERNATING ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute top-[20%] left-[5%] w-[400px] h-[400px] bg-indigo/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8 space-y-24 lg:space-y-32">

        {{-- Feature 1: Text LEFT, visual RIGHT --}}
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full mb-6 text-xs font-medium text-soft tracking-widest uppercase">
                    <i class="fa-solid fa-brain text-mint-light text-[10px]"></i>
                    Smart learning
                </div>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-5">
                    Spaced repetition<br><span class="text-gradient italic">that remembers for you.</span>
                </h2>
                <p class="text-soft text-base mb-6 leading-relaxed">Our algorithm tracks what you know and what you struggle with. Words you miss come back more often. Words you know get spaced out. Science-backed, effortless.</p>
                <ul class="space-y-3">
                    @foreach(['Adapts to your memory patterns', 'Focuses on your weak spots', 'Optimizes review timing'] as $item)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-mint-light"></i>{{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="glass-card rounded-3xl p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-[150px] h-[150px] bg-mint/5 rounded-full blur-[60px]"></div>
                <div class="relative space-y-3">
                    <div class="text-xs text-muted uppercase tracking-widest mb-4">Review schedule</div>
                    @foreach([
                        ['word' => 'bonjour', 'strength' => 95, 'next' => '3 days'],
                        ['word' => 'merci', 'strength' => 82, 'next' => '1 day'],
                        ['word' => 'maison', 'strength' => 45, 'next' => '4 hours'],
                        ['word' => 'chien', 'strength' => 20, 'next' => 'Now'],
                    ] as $word)
                        <div class="flex items-center gap-4 p-3 bg-elevated/60 rounded-xl">
                            <div class="font-display font-bold text-bright italic text-sm w-20">{{ $word['word'] }}</div>
                            <div class="flex-1">
                                <div class="w-full bg-night rounded-full h-1.5">
                                    <div class="bg-gradient-to-r from-mint to-mint-light rounded-full h-1.5 transition-all" style="width: {{ $word['strength'] }}%"></div>
                                </div>
                            </div>
                            <span class="text-[10px] font-semibold {{ $word['next'] === 'Now' ? 'text-mint-light' : 'text-muted' }} w-14 text-right">{{ $word['next'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Feature 2: Visual LEFT, text RIGHT --}}
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="order-2 lg:order-1 glass-card rounded-3xl p-8 relative overflow-hidden">
                <div class="absolute bottom-0 left-0 w-[150px] h-[150px] bg-sun/5 rounded-full blur-[60px]"></div>
                <div class="relative">
                    <div class="text-xs text-muted uppercase tracking-widest mb-4">Your languages</div>
                    <div class="space-y-3">
                        @foreach([
                            ['flag' => '🇫🇷', 'name' => 'French', 'level' => 'A2', 'progress' => 68],
                            ['flag' => '🇪🇸', 'name' => 'Spanish', 'level' => 'A1', 'progress' => 34],
                            ['flag' => '🇩🇪', 'name' => 'German', 'level' => 'B1', 'progress' => 82],
                        ] as $lang)
                            <div class="flex items-center gap-4 p-3 bg-elevated/60 rounded-xl">
                                <span class="text-xl">{{ $lang['flag'] }}</span>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-sm font-semibold text-bright">{{ $lang['name'] }}</span>
                                        <span class="text-[10px] font-semibold text-sky-light bg-sky/10 px-2 py-0.5 rounded-full">{{ $lang['level'] }}</span>
                                    </div>
                                    <div class="w-full bg-night rounded-full h-1.5">
                                        <div class="bg-gradient-to-r from-sky to-sky-light rounded-full h-1.5" style="width: {{ $lang['progress'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 p-3 border border-dashed border-border/50 rounded-xl flex items-center justify-center gap-2 text-sm text-muted hover:text-sky-light hover:border-sky/20 transition-all cursor-pointer">
                        <i class="fa-solid fa-plus text-xs"></i> Add a language
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full mb-6 text-xs font-medium text-soft tracking-widest uppercase">
                    <i class="fa-solid fa-globe text-sky-light text-[10px]"></i>
                    Multi-language
                </div>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-5">
                    Learn multiple languages<br><span class="text-gradient italic">at the same time.</span>
                </h2>
                <p class="text-soft text-base mb-6 leading-relaxed">With Premium, switch between all 2 languages freely. Each has its own progress, streaks, and level — so you can learn at your own pace.</p>
                <ul class="space-y-3">
                    @foreach(['Independent progress per language', 'Switch languages in one tap', 'From A1 beginner to C2 mastery'] as $item)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-sky-light"></i>{{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Feature 3: Text LEFT, visual RIGHT --}}
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full mb-6 text-xs font-medium text-soft tracking-widest uppercase">
                    <i class="fa-solid fa-gamepad text-sun-light text-[10px]"></i>
                    Gamification
                </div>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-5">
                    Stay motivated with<br><span class="text-gradient italic">rewards that matter.</span>
                </h2>
                <p class="text-soft text-base mb-6 leading-relaxed">Every lesson earns XP. Every day builds your streak. Unlock achievements, climb the leaderboard, and level up as you progress. Learning has never felt this rewarding.</p>
                <ul class="space-y-3">
                    @foreach(['Daily streaks & XP system', 'Unlockable achievements', 'Compete on the leaderboard'] as $item)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-sun-light"></i>{{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="glass-card rounded-3xl p-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-[120px] h-[120px] bg-sun/5 rounded-full blur-[50px]"></div>
                <div class="relative">
                    <div class="text-xs text-muted uppercase tracking-widest mb-4">Leaderboard</div>
                    <div class="space-y-2">
                        @foreach([
                            ['rank' => 1, 'name' => 'Emma S.', 'xp' => '3,210', 'me' => false],
                            ['rank' => 2, 'name' => 'Lucas M.', 'xp' => '2,890', 'me' => false],
                            ['rank' => 3, 'name' => 'You', 'xp' => '2,450', 'me' => true],
                            ['rank' => 4, 'name' => 'Sophie L.', 'xp' => '2,100', 'me' => false],
                            ['rank' => 5, 'name' => 'Max K.', 'xp' => '1,870', 'me' => false],
                        ] as $player)
                            <div class="flex items-center gap-3 p-3 rounded-xl {{ $player['me'] ? 'bg-sun/10 border border-sun/20' : 'bg-elevated/60' }}">
                                <span class="w-6 text-center text-xs font-bold {{ $player['me'] ? 'text-sun-light' : 'text-muted' }}">{{ $player['rank'] }}</span>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-sun/25 to-rose/15 flex items-center justify-center">
                                    <i class="fa-solid fa-user text-[9px] text-bright/40"></i>
                                </div>
                                <span class="flex-1 text-sm {{ $player['me'] ? 'text-sun-light font-semibold' : 'text-bright' }}">{{ $player['name'] }}</span>
                                <span class="text-xs font-semibold {{ $player['me'] ? 'text-sun-light' : 'text-muted' }}">{{ $player['xp'] }} XP</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== TESTIMONIALS MARQUEE ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="text-center max-w-2xl mx-auto mb-14 px-6">
        <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full mb-6 text-xs font-medium text-soft tracking-widest uppercase">
            <i class="fa-solid fa-heart text-indigo-light text-[10px]"></i>
            Loved by learners
        </div>
        <h2 class="font-display text-4xl sm:text-5xl font-bold text-bright tracking-tight">
            What our learners <span class="text-gradient italic">say.</span>
        </h2>
    </div>

    @php
        $row1 = [
            ['quote' => 'The streak system is addictive in the best way. 34 days straight learning Spanish!', 'name' => 'Sarah K.', 'flag' => 'gb', 'location' => 'London, UK', 'stars' => 5],
            ['quote' => 'Finally an app that feels premium. The spaced repetition actually works.', 'name' => 'Thomas B.', 'flag' => 'de', 'location' => 'Berlin, Germany', 'stars' => 5],
            ['quote' => 'Learning German and Japanese at the same time. Switching between languages is seamless.', 'name' => 'Mira L.', 'flag' => 'nl', 'location' => 'Amsterdam, Netherlands', 'stars' => 5],
            ['quote' => 'My kids and I learn together on the Family plan. The shared streak keeps us accountable!', 'name' => 'David R.', 'flag' => 'us', 'location' => 'New York, USA', 'stars' => 5],
            ['quote' => 'Fluence is the first app where I actually made it past A1. Short but effective lessons.', 'name' => 'Celine M.', 'flag' => 'be', 'location' => 'Brussels, Belgium', 'stars' => 5],
            ['quote' => '5 minutes a day during my coffee break. Already at level 6 in Portuguese.', 'name' => 'James W.', 'flag' => 'au', 'location' => 'Sydney, Australia', 'stars' => 4],
        ];
        $row2 = [
            ['quote' => 'The flashcards with audio are incredible. My pronunciation has improved so much.', 'name' => 'Anna P.', 'flag' => 'se', 'location' => 'Stockholm, Sweden', 'stars' => 5],
            ['quote' => 'I love how the app remembers what I struggle with and keeps testing me on it.', 'name' => 'Kevin O.', 'flag' => 'ie', 'location' => 'Dublin, Ireland', 'stars' => 5],
            ['quote' => 'Beautiful design, no ads, no distractions. Just pure learning. Worth every cent.', 'name' => 'Lisa N.', 'flag' => 'ch', 'location' => 'Zurich, Switzerland', 'stars' => 5],
            ['quote' => 'Went from zero to ordering food in Italian on my holiday. Thank you Fluence!', 'name' => 'Marco V.', 'flag' => 'br', 'location' => 'São Paulo, Brazil', 'stars' => 5],
            ['quote' => 'The leaderboard is so motivating. I keep pushing to stay in the top 3.', 'name' => 'Sophie T.', 'flag' => 'fr', 'location' => 'Paris, France', 'stars' => 5],
            ['quote' => 'Best language app I have used. Clean, fast and actually teaches you something.', 'name' => 'Noah H.', 'flag' => 'at', 'location' => 'Vienna, Austria', 'stars' => 4],
        ];
    @endphp

    {{-- Row 1 — scrolls left --}}
    <div class="relative mb-4">
        <div class="flex animate-[marqueeLeft_60s_linear_infinite] w-max gap-4">
            @foreach(array_merge($row1, $row1) as $review)
                <div class="glass-card rounded-2xl p-5 w-[340px] shrink-0">
                    <div class="flex gap-0.5 mb-3">
                        @for($i = 0; $i < $review['stars']; $i++)
                            <i class="fa-solid fa-star text-indigo-light text-[10px]"></i>
                        @endfor
                        @for($i = $review['stars']; $i < 5; $i++)
                            <i class="fa-solid fa-star text-border text-[10px]"></i>
                        @endfor
                    </div>
                    <p class="text-sm text-soft leading-relaxed mb-4">"{{ $review['quote'] }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo/25 to-sun/15 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-user text-[9px] text-bright/40"></i>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-bright">{{ $review['name'] }}</div>
                            <div class="text-[10px] text-muted flex items-center gap-1.5"><img src="https://flagcdn.com/w20/{{ $review['flag'] }}.png" alt="" class="w-3.5 h-2.5 rounded-sm opacity-60">{{ $review['location'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Row 2 — scrolls right --}}
    <div class="relative">
        <div class="flex animate-[marqueeRight_65s_linear_infinite] w-max gap-4">
            @foreach(array_merge($row2, $row2) as $review)
                <div class="glass-card rounded-2xl p-5 w-[340px] shrink-0">
                    <div class="flex gap-0.5 mb-3">
                        @for($i = 0; $i < $review['stars']; $i++)
                            <i class="fa-solid fa-star text-indigo-light text-[10px]"></i>
                        @endfor
                        @for($i = $review['stars']; $i < 5; $i++)
                            <i class="fa-solid fa-star text-border text-[10px]"></i>
                        @endfor
                    </div>
                    <p class="text-sm text-soft leading-relaxed mb-4">"{{ $review['quote'] }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo/25 to-sun/15 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-user text-[9px] text-bright/40"></i>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-bright">{{ $review['name'] }}</div>
                            <div class="text-[10px] text-muted flex items-center gap-1.5"><img src="https://flagcdn.com/w20/{{ $review['flag'] }}.png" alt="" class="w-3.5 h-2.5 rounded-sm opacity-60">{{ $review['location'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Fade edges --}}
    <div class="pointer-events-none absolute inset-y-0 left-0 w-24 bg-gradient-to-r from-night to-transparent z-10"></div>
    <div class="pointer-events-none absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-night to-transparent z-10"></div>
</section>

{{-- ===== PRICING TEASER ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-night via-surface/30 to-night"></div>
    <div class="absolute top-[20%] left-[40%] w-[600px] h-[600px] bg-indigo/4 rounded-full blur-[180px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full mb-6 text-xs font-medium text-soft tracking-widest uppercase">
                <i class="fa-solid fa-gem text-indigo-light text-[10px]"></i>
                Plans & pricing
            </div>
            <h2 class="font-display text-4xl sm:text-5xl font-bold text-bright tracking-tight mb-5">
                Start free. <span class="text-gradient italic">Grow further.</span>
            </h2>
            <p class="text-soft text-lg leading-relaxed">Begin your journey at no cost. Upgrade to unlock every language and level.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-5 max-w-5xl mx-auto">
            {{-- Free --}}
            <div class="glass-card rounded-3xl p-8 flex flex-col">
                <div class="text-xs font-semibold text-muted uppercase tracking-widest mb-4">Free</div>
                <div class="flex items-baseline gap-1 mb-1">
                    <span class="text-4xl font-display font-bold text-bright">&euro;0</span>
                </div>
                <p class="text-sm text-muted mb-6">1 language, A1 level</p>

                <ul class="space-y-2.5 mb-8 flex-1">
                    @foreach(['1 language', 'A1 (beginner) level', 'Basic exercises', 'Streaks & XP'] as $feat)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-indigo-light"></i>{{ $feat }}
                        </li>
                    @endforeach
                </ul>

                <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full px-6 py-3.5 glass hover:bg-elevated text-text text-sm font-semibold rounded-full transition-all duration-300">
                    Get started free
                </a>
            </div>

            {{-- Premium --}}
            <div class="glass-card rounded-3xl p-8 flex flex-col relative border-indigo/30 glow-indigo">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-4 py-1 bg-indigo text-white text-[11px] font-semibold rounded-full flex items-center gap-1.5">
                    <i class="fa-solid fa-star text-[9px]"></i> Most popular
                </div>

                <div class="text-xs font-semibold text-indigo-light uppercase tracking-widest mb-4">Premium</div>
                <div class="flex items-baseline gap-1 mb-1">
                    <span class="text-4xl font-display font-bold text-bright">&euro;5.99</span>
                    <span class="text-muted text-sm">/ month</span>
                </div>
                <p class="text-sm text-muted mb-6">All languages, all levels</p>

                <ul class="space-y-2.5 mb-8 flex-1">
                    @foreach(['All 2 languages', 'All levels (A1–C2)', 'Unlimited lessons', 'All exercise types', 'Spaced repetition'] as $feat)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-indigo-light"></i>{{ $feat }}
                        </li>
                    @endforeach
                </ul>

                <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full px-6 py-3.5 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_30px_var(--color-indigo-glow)]">
                    <i class="fa-solid fa-crown text-xs mr-2"></i> Start free trial
                </a>
            </div>

            {{-- Family --}}
            <div class="glass-card rounded-3xl p-8 flex flex-col">
                <div class="text-xs font-semibold text-sun uppercase tracking-widest mb-4">Family</div>
                <div class="flex items-baseline gap-1 mb-1">
                    <span class="text-4xl font-display font-bold text-bright">&euro;9.99</span>
                    <span class="text-muted text-sm">/ month</span>
                </div>
                <p class="text-sm text-muted mb-6">Premium for 3 accounts</p>

                <ul class="space-y-2.5 mb-8 flex-1">
                    @foreach(['Everything in Premium', 'Up to 3 accounts', 'Individual profiles', 'Family progress overview', 'Shared family streak'] as $feat)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-indigo-light"></i>{{ $feat }}
                        </li>
                    @endforeach
                </ul>

                <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full px-6 py-3.5 glass hover:bg-elevated text-text text-sm font-semibold rounded-full transition-all duration-300">
                    Start free trial
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-muted mt-6">
            <a href="{{ route('pricing') }}" class="hover:text-indigo-light transition-colors duration-200">View full comparison & FAQ <i class="fa-solid fa-arrow-right text-[9px] ml-1"></i></a>
        </p>
    </div>
</section>

{{-- ===== FINAL CTA — full width, flows into footer ===== --}}
<section class="relative overflow-hidden py-16 lg:py-20">
    {{-- Animated gradient background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-indigo/15 via-surface to-indigo/8 animate-[ctaGradient_8s_ease-in-out_infinite_alternate]"></div>
    <div class="absolute inset-0 bg-gradient-to-tl from-indigo/8 via-transparent to-indigo/10 animate-[ctaGradient2_10s_ease-in-out_infinite_alternate]"></div>

    {{-- Floating blobs --}}
    <div class="absolute top-[10%] left-[10%] w-[500px] h-[500px] bg-indigo/10 rounded-full blur-[180px] animate-[blob1_18s_ease-in-out_infinite]"></div>
    <div class="absolute bottom-[10%] right-[10%] w-[400px] h-[400px] bg-indigo/8 rounded-full blur-[160px] animate-[blob2_22s_ease-in-out_infinite]"></div>

    {{-- Subtle grain --}}
    <div class="absolute inset-0 opacity-[0.015]" style="background-image: radial-gradient(circle, rgba(139,123,245,0.5) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative max-w-3xl mx-auto px-6 lg:px-8 text-center">
        <div class="w-16 h-16 mx-auto bg-indigo/10 rounded-2xl flex items-center justify-center mb-8 backdrop-blur-sm">
            <i class="fa-solid fa-language text-indigo-light text-2xl"></i>
        </div>
        <h2 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-bright tracking-tight mb-5">Ready to begin?</h2>
        <div class="gold-line mx-auto my-6"></div>
        <p class="text-lg text-soft mb-10 max-w-xl mx-auto">Join thousands of learners making progress every day.</p>
        <a href="{{ route('register') }}" class="group inline-flex items-center justify-center gap-3 px-10 py-4 bg-indigo hover:bg-indigo-light text-white font-bold rounded-full transition-all duration-500 hover:shadow-[0_0_60px_var(--color-indigo-glow)] text-base">
            Start today &mdash; it's free
            <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
        </a>
        <p class="text-xs text-muted mt-5 flex items-center justify-center gap-2">
            <i class="fa-solid fa-shield-check text-indigo-light text-[10px]"></i>
            No credit card required. Cancel anytime.
        </p>
    </div>
</section>

@endsection
