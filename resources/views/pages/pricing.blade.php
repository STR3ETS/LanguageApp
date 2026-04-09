@extends('layouts.app')

@section('title', 'Pricing - Fluence')

@section('content')

<x-page-hero
    title="Choose your"
    highlight="plan."
    subtitle="Start free, upgrade when you're ready. No hidden fees, no surprises."
    badge="Simple, transparent pricing"
    badge-icon="fa-solid fa-gem"
/>

{{-- ===== PRICING CARDS ===== --}}
<section class="py-16 border-t border-border/30 relative overflow-hidden">
    <div class="absolute top-[10%] left-[40%] w-[500px] h-[500px] bg-indigo/4 rounded-full blur-[160px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8" x-data="{ annual: true }">

        {{-- Toggle --}}
        <div class="flex justify-center mb-12">
            <div class="inline-flex items-center gap-3 p-1.5 glass rounded-full">
                <button @click="annual = false" :class="!annual ? 'bg-indigo text-white shadow-lg' : 'text-soft hover:text-bright'" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300">
                    Monthly
                </button>
                <button @click="annual = true" :class="annual ? 'bg-indigo text-white shadow-lg' : 'text-soft hover:text-bright'" class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300">
                    Annual <span class="text-[10px] px-1.5 py-0.5 bg-indigo/20 text-indigo-light rounded-full ml-1 font-semibold">-33%</span>
                </button>
            </div>
        </div>

        {{-- Cards --}}
        <div class="grid md:grid-cols-3 gap-5 max-w-5xl mx-auto">
            {{-- Free --}}
            <div class="glass-card rounded-3xl p-8 flex flex-col">
                <div class="text-xs font-semibold text-muted uppercase tracking-widest mb-4">Free</div>
                <div class="flex items-baseline gap-1 mb-1">
                    <span class="text-4xl font-display font-bold text-bright">&euro;0</span>
                </div>
                <p class="text-sm text-muted mb-8">Forever free. No card needed.</p>

                <ul class="space-y-3 mb-8 flex-1">
                    @foreach(['1 language of your choice', 'A1 (beginner) level only', 'Basic exercises', 'Progress tracking', 'Streaks & XP', 'No ads'] as $feat)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-indigo-light"></i>{{ $feat }}
                        </li>
                    @endforeach
                    @foreach(['A2 and higher levels', 'All exercise types', 'Unlimited languages', 'Spaced repetition', 'Priority support'] as $feat)
                        <li class="flex items-center gap-3 text-sm text-muted line-through decoration-border">
                            <i class="fa-solid fa-circle-xmark text-xs text-border"></i>{{ $feat }}
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
                    <span class="text-4xl font-display font-bold text-bright" x-text="annual ? '€5.99' : '€8.99'"></span>
                    <span class="text-muted text-sm">/ month</span>
                </div>
                <p class="text-sm text-muted mb-1" x-show="annual" x-cloak>Billed as &euro;71.88 per year</p>
                <p class="text-sm text-muted mb-1" x-show="!annual">Billed monthly</p>
                <p class="text-xs text-indigo-light mb-8" x-show="annual" x-cloak><i class="fa-solid fa-tag text-[10px] mr-1"></i>You save &euro;36 per year</p>
                <div x-show="!annual" class="mb-8"></div>

                <ul class="space-y-3 mb-8 flex-1">
                    @foreach(['All 2 languages', 'All levels (A1–C2)', 'Unlimited lessons', 'All exercise types', 'Flashcards with audio', 'Spaced repetition', 'Progress dashboard', 'Priority support'] as $feat)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-indigo-light"></i>{{ $feat }}
                        </li>
                    @endforeach
                </ul>

                <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full px-6 py-3.5 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_30px_var(--color-indigo-glow)]">
                    <i class="fa-solid fa-crown text-xs mr-2"></i> Start free trial
                </a>
                <p class="text-center text-[11px] text-muted mt-3">7 days free, cancel anytime</p>
            </div>

            {{-- Family --}}
            <div class="glass-card rounded-3xl p-8 flex flex-col">
                <div class="text-xs font-semibold text-sun uppercase tracking-widest mb-4">Family</div>
                <div class="flex items-baseline gap-1 mb-1">
                    <span class="text-4xl font-display font-bold text-bright" x-text="annual ? '€9.99' : '€14.99'"></span>
                    <span class="text-muted text-sm">/ month</span>
                </div>
                <p class="text-sm text-muted mb-1" x-show="annual" x-cloak>Billed as &euro;119.88 per year</p>
                <p class="text-sm text-muted mb-1" x-show="!annual">Billed monthly</p>
                <p class="text-xs text-sun mb-8" x-show="annual" x-cloak><i class="fa-solid fa-tag text-[10px] mr-1"></i>You save &euro;60 per year</p>
                <div x-show="!annual" class="mb-8"></div>

                <ul class="space-y-3 mb-8 flex-1">
                    @foreach(['Everything in Premium', 'Up to 3 accounts', 'All languages & levels', 'Individual profiles', 'Family progress overview', 'Shared family streak', 'Family leaderboard', 'One single subscription'] as $feat)
                        <li class="flex items-center gap-3 text-sm text-text">
                            <i class="fa-solid fa-circle-check text-xs text-indigo-light"></i>{{ $feat }}
                        </li>
                    @endforeach
                </ul>

                <a href="{{ route('register') }}" class="inline-flex items-center justify-center w-full px-6 py-3.5 glass hover:bg-elevated text-text text-sm font-semibold rounded-full transition-all duration-300">
                    Start free trial
                </a>
                <p class="text-center text-[11px] text-muted mt-3">7 days free, cancel anytime</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== WHAT'S INCLUDED ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute bottom-[20%] left-[10%] w-[400px] h-[400px] bg-indigo/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <h2 class="font-display text-4xl sm:text-5xl font-bold text-bright tracking-tight mb-5">
                Everything included in <span class="text-gradient italic">Premium.</span>
            </h2>
            <p class="text-soft text-lg">One subscription. No add-ons. No per-language charges. Here's what you get.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 max-w-5xl mx-auto">
            @foreach([
                ['icon' => 'fa-globe', 'title' => 'All 2 languages', 'desc' => 'Dutch and Turkish (more coming soon).', 'color' => 'sky'],
                ['icon' => 'fa-layer-group', 'title' => 'All levels A1–C2', 'desc' => 'Start from scratch or jump ahead. Every language offers a full progression from beginner to advanced.', 'color' => 'indigo'],
                ['icon' => 'fa-infinity', 'title' => 'Unlimited lessons', 'desc' => 'No daily lesson limits. Learn as much or as little as you want, whenever you want.', 'color' => 'mint'],
                ['icon' => 'fa-brain', 'title' => 'Spaced repetition', 'desc' => 'Our algorithm schedules reviews at the perfect moment so you never forget what you\'ve learned.', 'color' => 'mint'],
                ['icon' => 'fa-headphones', 'title' => 'Audio flashcards', 'desc' => 'Listen to native pronunciation and build audio recognition alongside written vocabulary.', 'color' => 'sun'],
                ['icon' => 'fa-chart-line', 'title' => 'Progress dashboard', 'desc' => 'Track your XP, streaks, levels, and see how you rank on the global leaderboard.', 'color' => 'sky'],
                ['icon' => 'fa-shuffle', 'title' => 'All exercise types', 'desc' => 'Translation, matching, fill-in-the-blank, and listening exercises for well-rounded learning.', 'color' => 'indigo'],
                ['icon' => 'fa-trophy', 'title' => 'Achievements', 'desc' => 'Unlock badges and rewards as you hit milestones. Share your progress and stay motivated.', 'color' => 'sun'],
                ['icon' => 'fa-headset', 'title' => 'Priority support', 'desc' => 'Get help fast. Premium users are at the front of the queue for any questions or issues.', 'color' => 'rose'],
            ] as $feature)
                <div class="glass-card rounded-2xl p-6 group hover:border-{{ $feature['color'] }}/15 transition-all duration-500">
                    <div class="w-10 h-10 bg-{{ $feature['color'] }}/10 rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-solid {{ $feature['icon'] }} text-{{ $feature['color'] }}-light text-sm"></i>
                    </div>
                    <h3 class="font-display font-bold text-bright mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-sm text-muted leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== COMPARISON ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="relative max-w-3xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-5">How Fluence <span class="text-gradient italic">compares.</span></h2>
        </div>
        <div class="glass-card rounded-2xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-border/30">
                        <th class="text-left p-4 text-muted font-medium"></th>
                        <th class="p-4 text-center text-indigo-light font-bold">Fluence</th>
                        <th class="p-4 text-center text-muted font-medium">Duolingo+</th>
                        <th class="p-4 text-center text-muted font-medium">Babbel</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/30">
                    @foreach([
                        ['feature' => 'Free plan', 'fluence' => '1 lang, A1', 'duo' => 'With ads', 'babbel' => 'Trial only'],
                        ['feature' => 'Monthly price', 'fluence' => '€8.99', 'duo' => '€8.99', 'babbel' => '€12.95'],
                        ['feature' => 'Annual price', 'fluence' => '€5.99/mo', 'duo' => '€4.58/mo', 'babbel' => '€8.95/mo'],
                        ['feature' => 'All languages', 'fluence' => true, 'duo' => true, 'babbel' => false],
                        ['feature' => 'All levels (A1–C2)', 'fluence' => true, 'duo' => true, 'babbel' => true],
                        ['feature' => 'Family plan', 'fluence' => '3 accounts', 'duo' => '6 accounts', 'babbel' => false],
                        ['feature' => 'Spaced repetition', 'fluence' => true, 'duo' => false, 'babbel' => true],
                        ['feature' => 'No ads (even free)', 'fluence' => true, 'duo' => false, 'babbel' => true],
                    ] as $row)
                        <tr>
                            <td class="p-4 text-text">{{ $row['feature'] }}</td>
                            @foreach(['fluence', 'duo', 'babbel'] as $col)
                                <td class="p-4 text-center">
                                    @if($row[$col] === true)
                                        <i class="fa-solid fa-circle-check {{ $col === 'fluence' ? 'text-indigo-light' : 'text-soft' }}"></i>
                                    @elseif($row[$col] === false)
                                        <i class="fa-solid fa-circle-xmark text-border"></i>
                                    @else
                                        <span class="{{ $col === 'fluence' ? 'text-bright font-semibold' : 'text-muted' }}">{{ $row[$col] }}</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- ===== FAQ ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30">
    <div class="max-w-2xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight">Frequently asked <span class="text-gradient italic">questions.</span></h2>
        </div>
        <div class="space-y-3">
            @foreach([
                ['q' => 'What can I do with the free plan?', 'a' => 'The free plan lets you learn 1 language at A1 (beginner) level. It includes basic exercises, progress tracking, streaks, and XP. No ads, no credit card. Perfect to try Fluence before upgrading.'],
                ['q' => 'What do I get with Premium?', 'a' => 'Premium unlocks all 2 languages, all levels from A1 to C2, unlimited lessons, all exercise types, spaced repetition, audio flashcards, and priority support. Everything, basically.'],
                ['q' => 'How does the Family plan work?', 'a' => 'The Family plan includes everything in Premium for up to 3 separate accounts. Each family member gets their own profile, progress, and streaks. One subscription, three learners.'],
                ['q' => 'Is there a free trial for Premium?', 'a' => 'Yes! Both Premium and Family include a 7-day free trial. No credit card required to start. You can cancel anytime during the trial.'],
                ['q' => 'Can I switch plans?', 'a' => 'Yes. Upgrade from Free to Premium or Family anytime. Downgrade works too — your progress is always saved, you just lose access to premium features.'],
                ['q' => 'Can I cancel anytime?', 'a' => 'Yes. Cancel from your profile settings at any time. No questions asked, no hidden fees. Your subscription runs until the end of the billing period.'],
                ['q' => 'Do I keep my progress if I downgrade?', 'a' => 'Yes. Your progress, XP, and streaks are saved permanently. You\'ll keep access to your A1 content on the free plan. Upgrade again anytime to unlock everything.'],
                ['q' => 'Do you offer refunds?', 'a' => 'Yes. If you\'re not satisfied with Premium, contact us within 7 days of purchase for a full refund. No questions asked.'],
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
        <h2 class="font-display text-4xl sm:text-5xl font-bold text-bright tracking-tight mb-5">Start learning today.</h2>
        <div class="gold-line mx-auto my-6"></div>
        <p class="text-lg text-soft mb-10 max-w-xl mx-auto">Try Fluence free. Upgrade when you're ready.</p>
        <a href="{{ route('register') }}" class="group inline-flex items-center justify-center gap-3 px-10 py-4 bg-indigo hover:bg-indigo-light text-white font-bold rounded-full transition-all duration-500 hover:shadow-[0_0_60px_var(--color-indigo-glow)] text-base">
            Start today &mdash; it's free
            <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
        </a>
    </div>
</section>
@endsection
