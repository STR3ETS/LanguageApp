@extends('layouts.app')

@section('title', 'About - Fluence')

@section('content')

<x-page-hero
    title="We believe learning should"
    highlight="feel rewarding."
    subtitle="Fluence was built by a small team who got frustrated with language apps that felt like a chore. We wanted something different — beautiful, effective, and fun to use every day."
    badge="About us"
    badge-icon="fa-solid fa-heart"
    badge-color="rose"
/>

{{-- ===== OUR STORY ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute bottom-0 right-[10%] w-[400px] h-[400px] bg-mint/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            <div>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-6">
                    The story behind <span class="text-gradient italic">Fluence.</span>
                </h2>
                <div class="space-y-5 text-soft text-base leading-relaxed">
                    <p>It started with a simple observation: most language learning apps are either too gamified (fun but you don't learn much) or too academic (effective but boring). We wanted both.</p>
                    <p>We started building Fluence in 2024 from Amsterdam, Netherlands. A small team of language enthusiasts, designers, and engineers who believe that the best way to learn is through short, consistent daily practice — backed by real science.</p>
                    <p>Every feature in Fluence exists because research supports it. Spaced repetition, active recall, interleaving — these aren't buzzwords, they're the foundation of how our lessons work. We just wrapped them in an experience you'll actually want to open every day.</p>
                    <p>Today, Fluence offers 10 languages and serves over 2,400 active learners. We're still small, still independent, and still obsessed with making language learning better.</p>
                </div>
            </div>
            <div class="space-y-4">
                <div class="glass-card rounded-3xl p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-[120px] h-[120px] bg-indigo/5 rounded-full blur-[50px]"></div>
                    <div class="relative">
                        <div class="text-5xl font-display font-bold text-bright mb-2">2024</div>
                        <div class="text-sm text-muted mb-4">Founded in Amsterdam</div>
                        <p class="text-soft text-sm leading-relaxed">What started as a side project turned into a mission: build the most engaging language learning experience on the web.</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="glass-card rounded-2xl p-6 text-center">
                        <div class="text-3xl font-display font-bold text-bright mb-1">11</div>
                        <div class="text-xs text-muted uppercase tracking-widest">Languages</div>
                    </div>
                    <div class="glass-card rounded-2xl p-6 text-center">
                        <div class="text-3xl font-display font-bold text-bright mb-1">2,400+</div>
                        <div class="text-xs text-muted uppercase tracking-widest">Learners</div>
                    </div>
                    <div class="glass-card rounded-2xl p-6 text-center">
                        <div class="text-3xl font-display font-bold text-bright mb-1">50k+</div>
                        <div class="text-xs text-muted uppercase tracking-widest">Lessons done</div>
                    </div>
                    <div class="glass-card rounded-2xl p-6 text-center">
                        <div class="text-3xl font-display font-bold text-bright mb-1">4.8</div>
                        <div class="text-xs text-muted uppercase tracking-widest">Avg rating</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== MISSION ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute top-[20%] left-[5%] w-[400px] h-[400px] bg-indigo/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <h2 class="font-display text-4xl sm:text-5xl font-bold text-bright tracking-tight">
                Our <span class="text-gradient italic">mission.</span>
            </h2>
            <p class="text-soft text-lg mt-4">Build the most engaging way to learn a language. Not the cheapest, not the most gamified — the most engaging.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-5 max-w-5xl mx-auto">
            @foreach([
                ['icon' => 'fa-bullseye', 'title' => 'Focus on consistency', 'desc' => 'We don\'t try to cram everything into one session. Instead, we optimize for daily 5-minute habits. Research shows that short daily practice beats marathon sessions every single time. Our streak system, XP rewards, and bite-sized lessons are all designed around this principle.', 'color' => 'indigo'],
                ['icon' => 'fa-brain', 'title' => 'Science-backed methods', 'desc' => 'Every exercise in Fluence is powered by proven learning science: spaced repetition (you review words right before you\'d forget them), active recall (you retrieve answers instead of passively reading), and interleaving (mixing exercise types for deeper learning).', 'color' => 'mint'],
                ['icon' => 'fa-palette', 'title' => 'Design matters', 'desc' => 'We believe a beautiful, well-crafted experience makes you want to come back. No cluttered screens, no aggressive notifications, no guilt trips. Just a premium interface that respects your time and attention. If the app feels good to use, you\'ll use it more.', 'color' => 'sun'],
            ] as $value)
                <div class="glass-card rounded-2xl p-8 group hover:border-{{ $value['color'] }}/15 transition-all duration-500">
                    <div class="w-12 h-12 bg-{{ $value['color'] }}/10 rounded-2xl flex items-center justify-center mb-5">
                        <i class="fa-solid {{ $value['icon'] }} text-{{ $value['color'] }}-light text-lg"></i>
                    </div>
                    <h3 class="font-display text-lg font-bold text-bright mb-3">{{ $value['title'] }}</h3>
                    <p class="text-sm text-muted leading-relaxed">{{ $value['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== VALUES ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30 relative overflow-hidden">
    <div class="absolute bottom-[20%] right-[10%] w-[400px] h-[400px] bg-sky/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-start">
            <div>
                <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight mb-6">
                    What drives <span class="text-gradient italic">us.</span>
                </h2>
                <p class="text-soft text-base leading-relaxed mb-6">These aren't corporate values on a poster. They're the actual principles we use to make decisions every day — from what features to build to how we handle support tickets.</p>
                <p class="text-soft text-base leading-relaxed">If something doesn't align with these values, we don't do it. It's that simple.</p>
            </div>
            <div class="space-y-4">
                @foreach([
                    ['icon' => 'fa-rocket', 'title' => 'Ship fast, learn faster', 'desc' => 'We release new content and features every week. User feedback shapes our roadmap. We\'d rather ship something good today than something perfect next month.', 'color' => 'indigo'],
                    ['icon' => 'fa-users', 'title' => 'Learners first', 'desc' => 'Every decision starts with "does this help someone learn better?" If the answer is no, we skip it. Revenue, growth, metrics — all secondary to learning outcomes.', 'color' => 'sky'],
                    ['icon' => 'fa-gem', 'title' => 'Quality over quantity', 'desc' => 'We\'d rather have 11 excellent language courses than 50 mediocre ones. Every lesson is carefully crafted and reviewed before it goes live.', 'color' => 'mint'],
                    ['icon' => 'fa-eye', 'title' => 'Transparent pricing', 'desc' => 'No hidden fees, no dark patterns, no surprise charges. Free means free forever. Premium is clearly priced and clearly worth it. Cancel anytime means cancel anytime.', 'color' => 'sun'],
                    ['icon' => 'fa-shield-check', 'title' => 'Privacy by default', 'desc' => 'We don\'t sell your data. We don\'t track more than we need. We don\'t use your learning patterns for advertising. Your learning journey is yours alone.', 'color' => 'rose'],
                    ['icon' => 'fa-earth-americas', 'title' => 'Accessible to everyone', 'desc' => 'Language learning should be for everyone, regardless of budget. That\'s why we have a generous free plan and keep Premium affordable.', 'color' => 'indigo'],
                ] as $value)
                    <div class="glass-card rounded-2xl p-5 flex items-start gap-4 group hover:border-{{ $value['color'] }}/15 transition-all duration-500">
                        <div class="w-10 h-10 bg-{{ $value['color'] }}/10 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid {{ $value['icon'] }} text-{{ $value['color'] }}-light text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-bright mb-1">{{ $value['title'] }}</h3>
                            <p class="text-sm text-muted leading-relaxed">{{ $value['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== BASED IN ===== --}}
<section class="py-16 border-t border-border/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-indigo/5 via-transparent to-indigo/5"></div>
    <div class="relative max-w-4xl mx-auto px-6 lg:px-8">
        <div class="glass-card rounded-3xl p-8 lg:p-12 flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
            <div class="w-16 h-16 bg-indigo/10 rounded-2xl flex items-center justify-center shrink-0">
                <img src="https://flagcdn.com/w40/nl.png" alt="NL" class="w-8 h-6 rounded-sm">
            </div>
            <div>
                <h3 class="font-display text-xl font-bold text-bright mb-2">Based in Amsterdam, Netherlands</h3>
                <p class="text-soft text-sm leading-relaxed">Fluence is an independent company based in Amsterdam. No VC funding, no investors telling us what to build. Just a small team focused on making language learning better for everyone.</p>
            </div>
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo hover:bg-indigo-light text-white font-semibold rounded-full transition-all duration-300 shrink-0">
                Get in touch
            </a>
        </div>
    </div>
</section>

{{-- ===== CTA ===== --}}
<section class="relative overflow-hidden py-16 lg:py-20">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo/15 via-surface to-indigo/8"></div>
    <div class="absolute top-[10%] left-[10%] w-[500px] h-[500px] bg-indigo/10 rounded-full blur-[180px]"></div>

    <div class="relative max-w-3xl mx-auto px-6 lg:px-8 text-center">
        <h2 class="font-display text-4xl sm:text-5xl font-bold text-bright tracking-tight mb-5">Want to join the team?</h2>
        <div class="gold-line mx-auto my-6"></div>
        <p class="text-lg text-soft mb-10 max-w-xl mx-auto">We're always looking for passionate people who care about education and great design.</p>
        <a href="{{ route('contact') }}" class="group inline-flex items-center justify-center gap-3 px-10 py-4 bg-indigo hover:bg-indigo-light text-white font-bold rounded-full transition-all duration-500 hover:shadow-[0_0_60px_var(--color-indigo-glow)] text-base">
            Get in touch
            <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
        </a>
    </div>
</section>
@endsection
