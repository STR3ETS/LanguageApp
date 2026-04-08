@extends('layouts.app')

@section('title', 'How it works - Fluence')

@section('content')

<x-page-hero
    title="Learning that feels like"
    highlight="real progress."
    subtitle="No boring textbooks, no guilt. Fluence breaks language learning into small daily wins that actually stick."
    badge="How it works"
    badge-icon="fa-solid fa-wand-magic-sparkles"
/>

{{-- ===== THE JOURNEY ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute top-[30%] right-[5%] w-[400px] h-[400px] bg-indigo/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-6xl mx-auto px-6 lg:px-8 space-y-28 lg:space-y-36">

        {{-- Step 1 --}}
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo/10 rounded-full mb-4 text-[10px] font-semibold text-indigo-light uppercase tracking-widest">Step 01</div>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-5">Pick a language</h2>
                <p class="text-soft text-base leading-relaxed mb-6">Choose from 10 languages, including French, Spanish, German, Japanese, and more. Each language has its own complete learning path — from absolute beginner (A1) to advanced (C2).</p>
                <p class="text-soft text-base leading-relaxed mb-6">The free plan lets you learn 1 language at A1 level. With Premium, you unlock all 10 languages and every level. You can even learn multiple languages at the same time.</p>
                <ul class="space-y-3">
                    @foreach(['10 languages to choose from', 'A1 through C2 levels', 'Switch languages anytime with Premium'] as $item)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-indigo-light"></i>{{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="glass-card rounded-3xl p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-[150px] h-[150px] bg-indigo/5 rounded-full blur-[60px]"></div>
                <div class="relative grid grid-cols-3 gap-3">
                    @foreach([
                        ['flag' => '🇫🇷', 'name' => 'French'], ['flag' => '🇪🇸', 'name' => 'Spanish'], ['flag' => '🇩🇪', 'name' => 'German'],
                        ['flag' => '🇮🇹', 'name' => 'Italian'], ['flag' => '🇯🇵', 'name' => 'Japanese'], ['flag' => '🇳🇱', 'name' => 'Dutch'],
                        ['flag' => '🇵🇹', 'name' => 'Portuguese'], ['flag' => '🇹🇷', 'name' => 'Turkish'], ['flag' => '🇨🇳', 'name' => 'Chinese'],
                    ] as $i => $lang)
                        <div class="text-center p-4 {{ $i === 0 ? 'bg-indigo/10 border-indigo/20' : 'bg-elevated border-border' }} border rounded-2xl hover:border-indigo/20 transition-all duration-300 cursor-pointer group">
                            <div class="text-2xl mb-2 group-hover:scale-110 transition-transform duration-300">{{ $lang['flag'] }}</div>
                            <div class="text-[11px] font-medium {{ $i === 0 ? 'text-indigo-light' : 'text-soft' }}">{{ $lang['name'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Step 2 --}}
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div class="order-2 lg:order-1 glass-card rounded-3xl p-8 relative overflow-hidden">
                <div class="absolute bottom-0 left-0 w-[150px] h-[150px] bg-mint/5 rounded-full blur-[60px]"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-mint/15 flex items-center justify-center"><span class="text-sm">🇫🇷</span></div>
                            <span class="text-xs font-semibold text-soft">French · A1 · Lesson 3</span>
                        </div>
                        <div class="flex items-center gap-1 text-mint-light text-xs font-semibold">
                            <i class="fa-solid fa-bolt text-[10px]"></i> +15 XP
                        </div>
                    </div>
                    <div class="w-full bg-elevated rounded-full h-1.5 mb-8">
                        <div class="bg-gradient-to-r from-mint to-mint-light rounded-full h-1.5 w-[45%]"></div>
                    </div>
                    <p class="text-xs text-muted uppercase tracking-widest mb-3 text-center">Translate this sentence</p>
                    <p class="text-xl font-display font-bold text-bright italic mb-6 text-center">"Je suis content"</p>
                    <div class="space-y-2 max-w-xs mx-auto">
                        <div class="px-4 py-3 bg-elevated border border-border rounded-xl text-sm text-muted text-left">I am hungry</div>
                        <div class="px-4 py-3 bg-mint/10 border border-mint/25 rounded-xl text-sm text-bright font-medium text-left flex justify-between items-center">I am happy <i class="fa-solid fa-circle-check text-mint-light text-xs"></i></div>
                        <div class="px-4 py-3 bg-elevated border border-border rounded-xl text-sm text-muted text-left">I am tired</div>
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-mint/10 rounded-full mb-4 text-[10px] font-semibold text-mint-light uppercase tracking-widest">Step 02</div>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-5">Complete bite-sized lessons</h2>
                <p class="text-soft text-base leading-relaxed mb-6">Each lesson takes just 3-5 minutes and mixes different exercise types: translation, word matching, fill-in-the-blank, and listening exercises. You'll never get bored doing the same thing.</p>
                <p class="text-soft text-base leading-relaxed mb-6">Our spaced repetition algorithm tracks which words you know well and which ones you struggle with. It automatically schedules reviews at the perfect moment — right before you'd forget.</p>
                <ul class="space-y-3">
                    @foreach(['3-5 minute bite-sized lessons', '4 different exercise types', 'Spaced repetition built in', 'Adapts to your weak spots'] as $item)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-mint-light"></i>{{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Step 3 --}}
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-sun/10 rounded-full mb-4 text-[10px] font-semibold text-sun-light uppercase tracking-widest">Step 03</div>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-5">Build your streak</h2>
                <p class="text-soft text-base leading-relaxed mb-6">Come back every day and your streak grows. It's a simple idea — but it works. Data from our learners shows that users with a 7+ day streak retain 3x more vocabulary than those who learn sporadically.</p>
                <p class="text-soft text-base leading-relaxed mb-6">Your streak is your commitment visualized. Watch it grow on your dashboard, share it with your family on the Family plan, and feel the motivation of not wanting to break the chain.</p>
                <ul class="space-y-3">
                    @foreach(['Daily streak tracking', 'Streak freeze (coming soon)', 'Shared family streaks', '3x better retention with 7+ day streaks'] as $item)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-sun-light"></i>{{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="glass-card rounded-3xl p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-[150px] h-[150px] bg-sun/5 rounded-full blur-[60px]"></div>
                <div class="relative text-center">
                    <div class="text-6xl font-display font-bold text-bright mb-2">12</div>
                    <div class="text-sm text-muted mb-6">day streak</div>
                    <div class="flex justify-center gap-2 mb-6">
                        @foreach(['M','T','W','T','F','S','S','M','T','W','T','F'] as $i => $d)
                            <div class="flex flex-col items-center gap-1.5">
                                <div class="w-8 h-10 rounded-lg {{ $i < 12 ? 'bg-sun/15 border border-sun/25' : 'bg-elevated border border-border' }} flex items-center justify-center">
                                    @if($i < 12)<i class="fa-solid fa-check text-[7px] text-sun-light"></i>@endif
                                </div>
                                <span class="text-[8px] text-muted">{{ $d }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-sun/10 rounded-full text-xs text-sun-light font-semibold">
                        <i class="fa-solid fa-fire-flame-curved text-[10px]"></i> You're on fire! Keep going.
                    </div>
                </div>
            </div>
        </div>

        {{-- Step 4 --}}
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div class="order-2 lg:order-1 glass-card rounded-3xl p-8 relative overflow-hidden">
                <div class="absolute bottom-0 left-0 w-[150px] h-[150px] bg-sky/5 rounded-full blur-[60px]"></div>
                <div class="relative">
                    <div class="text-xs text-muted uppercase tracking-widest mb-4">Your progress</div>
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="bg-elevated rounded-xl p-4 text-center">
                            <div class="text-2xl font-display font-bold text-bright">2,450</div>
                            <div class="text-[10px] text-muted mt-1">Total XP</div>
                        </div>
                        <div class="bg-elevated rounded-xl p-4 text-center">
                            <div class="text-2xl font-display font-bold text-bright">Lvl 7</div>
                            <div class="text-[10px] text-muted mt-1">Current</div>
                        </div>
                        <div class="bg-elevated rounded-xl p-4 text-center">
                            <div class="text-2xl font-display font-bold text-bright">#3</div>
                            <div class="text-[10px] text-muted mt-1">Leaderboard</div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="flex justify-between text-xs mb-1.5">
                            <span class="text-soft">Level 7</span>
                            <span class="text-sky-light">280 XP to Level 8</span>
                        </div>
                        <div class="w-full bg-night rounded-full h-2">
                            <div class="bg-gradient-to-r from-sky to-sky-light rounded-full h-2 w-[72%]"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        @foreach([
                            ['icon' => 'fa-medal', 'label' => 'First Lesson', 'done' => true, 'color' => 'sun'],
                            ['icon' => 'fa-fire', 'label' => '7-Day Streak', 'done' => true, 'color' => 'rose'],
                            ['icon' => 'fa-bolt', 'label' => '1000 XP Earned', 'done' => true, 'color' => 'indigo'],
                            ['icon' => 'fa-crown', 'label' => 'Master Linguist', 'done' => false, 'color' => 'muted'],
                        ] as $badge)
                            <div class="flex items-center gap-3 p-2 rounded-lg {{ $badge['done'] ? '' : 'opacity-40' }}">
                                <div class="w-7 h-7 rounded-lg bg-{{ $badge['color'] }}/10 flex items-center justify-center">
                                    <i class="fa-solid {{ $badge['icon'] }} text-{{ $badge['color'] }}-light text-[10px]"></i>
                                </div>
                                <span class="text-sm {{ $badge['done'] ? 'text-bright' : 'text-muted' }}">{{ $badge['label'] }}</span>
                                @if($badge['done'])<i class="fa-solid fa-circle-check text-{{ $badge['color'] }}-light text-[10px] ml-auto"></i>@else<i class="fa-solid fa-lock text-[8px] text-muted ml-auto"></i>@endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-sky/10 rounded-full mb-4 text-[10px] font-semibold text-sky-light uppercase tracking-widest">Step 04</div>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-5">Level up and unlock</h2>
                <p class="text-soft text-base leading-relaxed mb-6">Every exercise earns you XP. Accumulate enough and you unlock the next level with new, harder content. It's a progression system inspired by the best games — applied to learning.</p>
                <p class="text-soft text-base leading-relaxed mb-6">Your dashboard shows everything: total XP, current level, streak, and where you rank on the leaderboard. Unlock achievements for milestones like your first lesson, a 7-day streak, or reaching 1000 XP.</p>
                <ul class="space-y-3">
                    @foreach(['XP earned per exercise', 'Level progression with harder content', 'Achievement badges for milestones', 'Global leaderboard'] as $item)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-sky-light"></i>{{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ===== EXERCISE TYPES ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute top-[30%] left-[10%] w-[400px] h-[400px] bg-indigo/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <h2 class="font-display text-4xl sm:text-5xl font-bold text-bright tracking-tight mb-5">
                Exercise types you'll <span class="text-gradient italic">love.</span>
            </h2>
            <p class="text-soft text-lg">Every lesson mixes different exercise types to keep things fresh and effective.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 max-w-5xl mx-auto">
            @foreach([
                ['icon' => 'fa-language', 'title' => 'Translation', 'desc' => 'Translate words and full sentences between your language and the target language. Tests both directions.', 'color' => 'indigo'],
                ['icon' => 'fa-puzzle-piece', 'title' => 'Word matching', 'desc' => 'Match words to their translations against the clock. Great for building quick recall and vocabulary.', 'color' => 'mint'],
                ['icon' => 'fa-pen', 'title' => 'Fill in the blank', 'desc' => 'Complete sentences with the correct word. Teaches grammar and context naturally, without boring rules.', 'color' => 'sun'],
                ['icon' => 'fa-volume-high', 'title' => 'Listening', 'desc' => 'Listen to native pronunciation and select or type what you hear. Trains your ear for real conversations.', 'color' => 'sky'],
            ] as $type)
                <div class="glass-card rounded-2xl p-6 text-center group hover:border-{{ $type['color'] }}/15 transition-all duration-500">
                    <div class="w-14 h-14 mx-auto bg-{{ $type['color'] }}/10 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid {{ $type['icon'] }} text-{{ $type['color'] }}-light text-xl"></i>
                    </div>
                    <h3 class="font-display font-bold text-bright mb-2">{{ $type['title'] }}</h3>
                    <p class="text-sm text-muted leading-relaxed">{{ $type['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== WHY IT WORKS ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute bottom-[20%] right-[10%] w-[400px] h-[400px] bg-mint/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            <div>
                <h2 class="font-display text-4xl sm:text-5xl font-bold text-bright tracking-tight mb-6">
                    The science behind <span class="text-gradient italic">Fluence.</span>
                </h2>
                <p class="text-soft text-base leading-relaxed mb-6">We didn't invent a new way to learn — we combined the best proven methods and wrapped them in an experience you'll actually enjoy using every day.</p>
                <p class="text-soft text-base leading-relaxed">Every feature in Fluence exists because research supports it. Spaced repetition, active recall, interleaving, and the testing effect are all baked into the lesson structure. You don't need to know how it works — just show up daily and the system does the rest.</p>
            </div>
            <div class="space-y-4">
                @foreach([
                    ['title' => 'Spaced Repetition', 'desc' => 'Words you struggle with appear more often. Words you know get reviewed less. Based on the Ebbinghaus forgetting curve, this is the most efficient way to memorize vocabulary.', 'icon' => 'fa-brain', 'color' => 'mint'],
                    ['title' => 'Active Recall', 'desc' => 'Instead of passively reading translations, you actively retrieve answers from memory. This strengthens neural pathways and makes knowledge stick 2-3x longer.', 'icon' => 'fa-lightbulb', 'color' => 'sun'],
                    ['title' => 'Interleaving', 'desc' => 'Lessons mix different exercise types and topics. This might feel harder, but research shows it produces deeper learning than practicing one skill at a time.', 'icon' => 'fa-shuffle', 'color' => 'sky'],
                    ['title' => 'The Testing Effect', 'desc' => 'Being tested on material is more effective than re-studying it. Every Fluence exercise is a mini-test, which means every minute you spend in the app is highly productive.', 'icon' => 'fa-clipboard-check', 'color' => 'indigo'],
                ] as $method)
                    <div class="glass-card rounded-2xl p-6 flex items-start gap-4 group hover:border-{{ $method['color'] }}/15 transition-all duration-500">
                        <div class="w-10 h-10 bg-{{ $method['color'] }}/10 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid {{ $method['icon'] }} text-{{ $method['color'] }}-light text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-bright mb-1">{{ $method['title'] }}</h3>
                            <p class="text-sm text-muted leading-relaxed">{{ $method['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== FAQ ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30">
    <div class="max-w-2xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight">Common <span class="text-gradient italic">questions.</span></h2>
        </div>
        <div class="space-y-3">
            @foreach([
                ['q' => 'How long are the lessons?', 'a' => 'Each lesson takes 3-5 minutes. Short enough to fit into any daily routine — your morning coffee, a bus ride, or a lunch break.'],
                ['q' => 'Do I need any prior knowledge?', 'a' => 'No. Every language starts at A1 (absolute beginner). We teach you from the very first word.'],
                ['q' => 'What if I already know some basics?', 'a' => 'You can move through A1 quickly and unlock A2 and beyond. The system adapts — if you already know a word, it won\'t keep testing you on it.'],
                ['q' => 'How is Fluence different from Duolingo?', 'a' => 'We focus on quality over quantity. Fewer languages but deeper courses, science-backed spaced repetition, no ads even on the free plan, and a premium design that respects your time.'],
                ['q' => 'Can I learn multiple languages?', 'a' => 'Yes, with Premium. Each language has independent progress, so you can learn French and Japanese at the same time without them interfering.'],
                ['q' => 'Is there a free trial?', 'a' => 'The free plan is free forever — 1 language at A1 level. Premium has a 7-day free trial with no credit card required.'],
            ] as $faq)
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="font-bold text-bright text-sm mb-2">{{ $faq['q'] }}</h3>
                    <p class="text-sm text-muted leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== CTA ===== --}}
<section class="relative overflow-hidden py-16 lg:py-20">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo/15 via-surface to-indigo/8"></div>
    <div class="absolute top-[10%] left-[10%] w-[500px] h-[500px] bg-indigo/10 rounded-full blur-[180px]"></div>

    <div class="relative max-w-3xl mx-auto px-6 lg:px-8 text-center">
        <h2 class="font-display text-4xl sm:text-5xl font-bold text-bright tracking-tight mb-5">Ready to try?</h2>
        <div class="gold-line mx-auto my-6"></div>
        <p class="text-lg text-soft mb-10 max-w-xl mx-auto">Pick your language and start your first lesson in under a minute.</p>
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
