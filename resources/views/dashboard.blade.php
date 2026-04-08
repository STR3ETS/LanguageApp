@extends('layouts.dashboard')

@section('content')
    @php
        $landmarks = config('landmarks');
        $hour = now()->hour;
        $greeting = $hour < 6 ? 'Night owl' : ($hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening'));
        $streakDays = $stats['current_streak'];

        // Rank system
        $ranks = [
            ['min' => 0, 'name' => 'Newcomer', 'icon' => 'fa-seedling', 'color' => 'muted'],
            ['min' => 100, 'name' => 'Explorer', 'icon' => 'fa-compass', 'color' => 'mint'],
            ['min' => 500, 'name' => 'Adventurer', 'icon' => 'fa-map', 'color' => 'sky'],
            ['min' => 1000, 'name' => 'Scholar', 'icon' => 'fa-book', 'color' => 'indigo'],
            ['min' => 2500, 'name' => 'Linguist', 'icon' => 'fa-language', 'color' => 'indigo'],
            ['min' => 5000, 'name' => 'Polyglot', 'icon' => 'fa-crown', 'color' => 'sun'],
            ['min' => 10000, 'name' => 'Legend', 'icon' => 'fa-gem', 'color' => 'rose'],
        ];
        $currentRank = $ranks[0];
        $nextRank = $ranks[1] ?? null;
        foreach ($ranks as $i => $rank) {
            if ($stats['total_xp'] >= $rank['min']) {
                $currentRank = $rank;
                $nextRank = $ranks[$i + 1] ?? null;
            }
        }
        $rankProgress = $nextRank ? min(100, round(($stats['total_xp'] - $currentRank['min']) / ($nextRank['min'] - $currentRank['min']) * 100)) : 100;

        // Word of the day
        $words = [
            ['word' => 'Serendipity', 'translation' => 'Finding something good without looking for it', 'lang' => 'English'],
            ['word' => 'Fernweh', 'translation' => 'An ache for distant places; the craving for travel', 'lang' => 'German'],
            ['word' => 'Saudade', 'translation' => 'A deep emotional state of longing for something absent', 'lang' => 'Portuguese'],
            ['word' => 'Hygge', 'translation' => 'A feeling of cozy contentment and well-being', 'lang' => 'Danish'],
            ['word' => 'Komorebi', 'translation' => 'Sunlight filtering through the leaves of trees', 'lang' => 'Japanese'],
            ['word' => 'Sobremesa', 'translation' => 'The time spent talking after a meal is finished', 'lang' => 'Spanish'],
            ['word' => 'Flâneur', 'translation' => 'A person who strolls and observes society', 'lang' => 'French'],
        ];
        $wordOfDay = $words[now()->dayOfYear % count($words)];
    @endphp

    <x-onboarding-tour />
    <script>
        if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
        window.scrollTo(0, 0);
        document.addEventListener('DOMContentLoaded', () => window.scrollTo(0, 0));
    </script>

    <div class="py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            {{-- ===== HERO — streak flame + CTA ===== --}}
            <div id="tour-hero" class="relative rounded-3xl overflow-hidden mb-6">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo/15 via-surface to-indigo/8 animate-[ctaGradient_8s_ease-in-out_infinite_alternate]"></div>
                <div class="absolute inset-0 bg-gradient-to-tl from-indigo/8 via-transparent to-indigo/10 animate-[ctaGradient2_10s_ease-in-out_infinite_alternate]"></div>
                <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-indigo/8 rounded-full blur-[150px] animate-[blob1_18s_ease-in-out_infinite]"></div>
                <div class="absolute bottom-0 left-[20%] w-[300px] h-[300px] bg-indigo/6 rounded-full blur-[120px] animate-[blob2_22s_ease-in-out_infinite]"></div>

                <div class="relative px-8 py-8 lg:py-10 flex flex-col lg:flex-row lg:items-center gap-6">
                    {{-- Streak visual --}}
                    <div class="flex items-center gap-5 flex-1">
                        @if($streakDays > 0)
                            <div class="relative shrink-0">
                                <div class="w-20 h-20 rounded-2xl bg-sun/15 flex items-center justify-center relative">
                                    <i class="fa-solid fa-fire-flame-curved text-sun-light text-3xl animate-pulse"></i>
                                    <div class="absolute -top-2 -right-2 w-7 h-7 bg-sun rounded-full flex items-center justify-center">
                                        <span class="text-xs font-bold text-night">{{ $streakDays }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="w-20 h-20 rounded-2xl bg-elevated flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-fire-flame-curved text-muted text-3xl"></i>
                            </div>
                        @endif

                        <div>
                            <div class="text-xs text-soft/60 uppercase tracking-widest mb-1">{{ now()->format('l, F j') }}</div>
                            <h1 class="font-display text-xl sm:text-2xl font-bold text-bright mb-1">
                                {{ $greeting }}, {{ auth()->user()->name }}!
                            </h1>
                            @if($streakDays === 0)
                                <p class="text-soft text-sm">Your streak is waiting. One lesson is all it takes to light the fire. 🔥</p>
                            @elseif($streakDays < 3)
                                <p class="text-soft text-sm">{{ $streakDays }} day streak — you're just getting started. Don't stop now! 💪</p>
                            @elseif($streakDays < 7)
                                <p class="text-soft text-sm">{{ $streakDays }} days strong. You're building a real habit here. ⚡</p>
                            @elseif($streakDays < 14)
                                <p class="text-soft text-sm">{{ $streakDays }} days! You're in the top 20% of all learners. Keep pushing. 🚀</p>
                            @elseif($streakDays < 30)
                                <p class="text-soft text-sm">{{ $streakDays }} days! Most people never make it this far. You're different. 🏆</p>
                            @else
                                <p class="text-soft text-sm">{{ $streakDays }} days. You're a machine. Absolute legend. 👑</p>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('learn.index') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-indigo hover:bg-indigo-light text-white font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_40px_var(--color-indigo-glow)] cursor-pointer group shrink-0 text-sm">
                        <i class="fa-solid fa-play text-xs"></i>
                        @if($streakDays === 0)
                            Start your streak
                        @else
                            Continue learning
                        @endif
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                    </a>
                </div>
            </div>

            {{-- ===== RANK + TODAY'S MISSIONS + WORD OF DAY ===== --}}
            <div id="tour-missions" class="grid lg:grid-cols-3 gap-4 mb-16">
                {{-- Rank card + filler --}}
                <div class="flex flex-col gap-4">
                <div class="glass-card rounded-2xl p-6 relative overflow-hidden group hover:border-{{ $currentRank['color'] }}/15 transition-all duration-500">
                    <div class="absolute top-0 right-0 w-[100px] h-[100px] bg-{{ $currentRank['color'] }}/5 rounded-full blur-[50px]"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-[10px] text-muted uppercase tracking-widest font-semibold">Your rank</div>
                            <div class="text-[10px] text-{{ $currentRank['color'] }}-light font-semibold">{{ number_format($stats['total_xp']) }} XP</div>
                        </div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-{{ $currentRank['color'] }}/10 rounded-xl flex items-center justify-center">
                                <i class="fa-solid {{ $currentRank['icon'] }} text-{{ $currentRank['color'] }}-light text-xl"></i>
                            </div>
                            <div>
                                <div class="font-display text-lg font-bold text-bright">{{ $currentRank['name'] }}</div>
                                @if($nextRank)
                                    <div class="text-[11px] text-muted">{{ number_format($nextRank['min'] - $stats['total_xp']) }} XP to {{ $nextRank['name'] }}</div>
                                @else
                                    <div class="text-[11px] text-{{ $currentRank['color'] }}-light">Max rank achieved!</div>
                                @endif
                            </div>
                        </div>
                        @if($nextRank)
                            <div class="w-full bg-elevated rounded-full h-2">
                                <div class="bg-gradient-to-r from-{{ $currentRank['color'] }} to-{{ $currentRank['color'] }}-light rounded-full h-2 transition-all duration-500" style="width: {{ $rankProgress }}%"></div>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- Filler --}}
                <div class="flex-1 rounded-2xl bg-gradient-to-b from-elevated/30 to-transparent min-h-[40px]"></div>
                </div>

                {{-- Today's missions --}}
                <div class="glass-card rounded-2xl p-6 relative overflow-hidden">
                    <div class="text-[10px] text-muted uppercase tracking-widest font-semibold mb-4">Today's missions</div>
                    @php
                        $todayLessons = min($stats['lessons_completed'], 3);
                        $missions = [
                            ['label' => 'Complete 1 lesson', 'done' => $todayLessons >= 1, 'xp' => 10, 'icon' => 'fa-book'],
                            ['label' => 'Complete 3 lessons', 'done' => $todayLessons >= 3, 'xp' => 25, 'icon' => 'fa-layer-group'],
                            ['label' => 'Keep your streak alive', 'done' => $streakDays > 0, 'xp' => 15, 'icon' => 'fa-fire'],
                        ];
                    @endphp
                    <div class="space-y-2.5">
                        @foreach($missions as $mission)
                            <div class="flex items-center gap-3 p-2.5 rounded-xl {{ $mission['done'] ? 'bg-mint/5' : 'bg-elevated/50' }}">
                                <div class="w-7 h-7 rounded-lg {{ $mission['done'] ? 'bg-mint/15' : 'bg-elevated' }} flex items-center justify-center shrink-0">
                                    @if($mission['done'])
                                        <i class="fa-solid fa-check text-mint-light text-[9px]"></i>
                                    @else
                                        <i class="fa-solid {{ $mission['icon'] }} text-muted text-[9px]"></i>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs {{ $mission['done'] ? 'text-mint-light line-through' : 'text-bright' }}">{{ $mission['label'] }}</div>
                                </div>
                                <span class="text-[10px] {{ $mission['done'] ? 'text-mint-light' : 'text-indigo-light' }} font-semibold shrink-0">+{{ $mission['xp'] }} XP</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3 pt-3 border-t border-border/20 flex items-center justify-between">
                        <span class="text-[10px] text-muted">{{ collect($missions)->where('done', true)->count() }}/{{ count($missions) }} completed</span>
                        <span class="text-[10px] text-indigo-light font-semibold">+{{ collect($missions)->where('done', true)->sum('xp') }} XP earned</span>
                    </div>
                </div>

                {{-- Word of the day + filler --}}
                <div class="flex flex-col gap-4">
                <div class="glass-card rounded-2xl p-6 relative overflow-hidden group hover:border-sky/15 transition-all duration-500">
                    <div class="absolute bottom-0 right-0 w-[100px] h-[100px] bg-sky/5 rounded-full blur-[50px]"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-[10px] text-muted uppercase tracking-widest font-semibold">Word of the day</div>
                            <div class="text-[10px] text-sky-light">{{ $wordOfDay['lang'] }}</div>
                        </div>
                        <div class="text-center py-3">
                            <div class="font-display text-2xl font-bold text-bright italic mb-2">{{ $wordOfDay['word'] }}</div>
                            <div class="gold-line mx-auto my-3"></div>
                            <p class="text-sm text-soft leading-relaxed">{{ $wordOfDay['translation'] }}</p>
                        </div>
                    </div>
                </div>
                {{-- Filler --}}
                <div class="flex-1 rounded-2xl bg-gradient-to-b from-elevated/30 to-transparent min-h-[40px]"></div>
                </div>
            </div>

            {{-- ===== CONTINUE LEARNING ===== --}}
            <div id="tour-languages" class="mb-16">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-muted uppercase tracking-widest flex items-center gap-2">
                        <i class="fa-solid fa-language text-indigo-light text-xs"></i> Continue learning
                    </h3>
                    <a href="{{ route('languages.index') }}" class="text-xs text-muted hover:text-indigo-light transition-colors flex items-center gap-1 cursor-pointer">
                        All languages <i class="fa-solid fa-arrow-right text-[9px]"></i>
                    </a>
                </div>

                @if($activeSubscriptions->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($activeSubscriptions as $sub)
                            @php $lm = $landmarks[$sub->language->slug] ?? ['img' => '', 'place' => '']; @endphp
                            <a href="{{ route('learn.language', $sub->language->slug) }}" class="glass-card rounded-2xl p-5 flex items-center gap-5 group hover:border-indigo/15 transition-all duration-300 cursor-pointer relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-[200px] h-[200px] bg-indigo/3 rounded-full blur-[80px] group-hover:bg-indigo/6 transition-all duration-500"></div>

                                <div class="w-14 h-14 rounded-2xl overflow-hidden shrink-0 ring-1 ring-border/20">
                                    <img src="{{ $lm['img'] }}" alt="{{ $sub->language->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>

                                <div class="relative flex-1 min-w-0">
                                    <div class="flex items-center gap-2.5 mb-1">
                                        <x-flag :code="$sub->language->flag_code" size="sm" />
                                        <span class="font-display text-base font-bold text-bright">{{ $sub->language->name }}</span>
                                        @if($sub->cefr_status === 'completed')
                                            <span class="text-[9px] px-2 py-0.5 bg-mint/10 text-mint-light rounded-full font-semibold flex items-center gap-1">
                                                <i class="fa-solid fa-check text-[7px]"></i> {{ $sub->current_cefr }}
                                            </span>
                                        @else
                                            <span class="text-[9px] px-2 py-0.5 bg-indigo/10 text-indigo-light rounded-full font-semibold">{{ $sub->current_cefr }}</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="flex-1 bg-elevated rounded-full h-1.5 max-w-[180px]">
                                            <div class="bg-gradient-to-r {{ $sub->cefr_status === 'completed' ? 'from-mint to-mint-light' : 'from-indigo to-indigo-light' }} rounded-full h-1.5" style="width: {{ $sub->cefr_total > 0 ? round($sub->cefr_done / $sub->cefr_total * 100) : 0 }}%"></div>
                                        </div>
                                        <span class="text-[10px] {{ $sub->cefr_status === 'completed' ? 'text-mint-light' : 'text-muted' }}">
                                            @if($sub->cefr_status === 'completed')
                                                {{ $sub->current_cefr }} completed
                                            @else
                                                {{ $sub->cefr_done }}/{{ $sub->cefr_total }} in {{ $sub->current_cefr }}
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="relative inline-flex items-center gap-2 px-4 py-2 bg-indigo/10 group-hover:bg-indigo/15 rounded-full transition-all duration-200 shrink-0">
                                    <i class="fa-solid fa-play text-[8px] text-indigo-light"></i>
                                    <span class="text-xs font-semibold text-indigo-light">Continue</span>
                                </div>
                            </a>
                        @endforeach

                        <a href="{{ route('languages.index') }}" class="block rounded-2xl border border-dashed border-border/30 hover:border-indigo/30 py-4 text-center transition-all duration-300 cursor-pointer group">
                            <span class="text-sm text-muted group-hover:text-indigo-light transition-colors"><i class="fa-solid fa-plus text-xs mr-1.5"></i>Add a language</span>
                        </a>
                    </div>
                @else
                    <div class="glass-card rounded-2xl p-10 text-center">
                        <div class="text-4xl mb-4">🌍</div>
                        <h3 class="font-display text-lg font-bold text-bright mb-2">Your journey starts here</h3>
                        <p class="text-sm text-muted mb-5">Pick a language and you'll be learning your first words in under a minute.</p>
                        <a href="{{ route('languages.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 cursor-pointer">
                            <i class="fa-solid fa-globe text-xs"></i> Choose a language
                        </a>
                    </div>
                @endif
            </div>

            {{-- ===== ACTIVITY + ACHIEVEMENTS ===== --}}
            <div id="tour-progress" class="grid lg:grid-cols-3 gap-4 mb-6">
                {{-- Activity chart --}}
                <div class="lg:col-span-2 glass-card rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-sm font-semibold text-bright flex items-center gap-2">
                            <i class="fa-solid fa-chart-line text-indigo-light text-xs"></i> Activity
                        </h3>
                        <span class="text-[11px] text-muted">Last 14 days</span>
                    </div>
                    <div class="relative h-32 mb-3" x-data="activityChart()" x-init="init()">
                        <canvas x-ref="chart" class="w-full h-full"></canvas>
                    </div>
                    <div class="flex justify-between text-[10px] text-muted">
                        @foreach($weeklyActivity as $i => $day)
                            @if($i % 2 === 0 || $day['is_today'])
                                <span class="{{ $day['is_today'] ? 'text-indigo-light font-semibold' : '' }}">{{ $day['short'] }}</span>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Achievements --}}
                <div class="glass-card rounded-2xl p-6">
                    <div class="text-[10px] text-muted uppercase tracking-widest font-semibold mb-4">Achievements</div>
                    @php
                        $achievements = [
                            ['icon' => 'fa-medal', 'label' => 'First Lesson', 'unlocked' => $stats['lessons_completed'] >= 1, 'color' => 'sun'],
                            ['icon' => 'fa-fire', 'label' => '3-Day Streak', 'unlocked' => $stats['current_streak'] >= 3, 'color' => 'rose'],
                            ['icon' => 'fa-bolt', 'label' => '100 XP', 'unlocked' => $stats['total_xp'] >= 100, 'color' => 'indigo'],
                            ['icon' => 'fa-star', 'label' => '7-Day Streak', 'unlocked' => $stats['current_streak'] >= 7, 'color' => 'sun'],
                            ['icon' => 'fa-globe', 'label' => '2 Languages', 'unlocked' => $stats['languages_active'] >= 2, 'color' => 'sky'],
                            ['icon' => 'fa-crown', 'label' => '1000 XP', 'unlocked' => $stats['total_xp'] >= 1000, 'color' => 'indigo'],
                        ];
                        $unlockedCount = collect($achievements)->where('unlocked', true)->count();
                    @endphp
                    <div class="grid grid-cols-3 gap-2 mb-4">
                        @foreach($achievements as $badge)
                            <div class="text-center group cursor-default">
                                <div class="w-11 h-11 mx-auto rounded-xl {{ $badge['unlocked'] ? 'bg-' . $badge['color'] . '/10' : 'bg-elevated opacity-25' }} flex items-center justify-center mb-1.5 group-hover:scale-110 transition-transform duration-200">
                                    <i class="fa-solid {{ $badge['icon'] }} {{ $badge['unlocked'] ? 'text-' . $badge['color'] . '-light' : 'text-muted' }} text-base"></i>
                                </div>
                                <div class="text-[9px] {{ $badge['unlocked'] ? 'text-soft' : 'text-muted opacity-40' }} leading-tight">{{ $badge['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center text-[10px] text-muted">{{ $unlockedCount }}/{{ count($achievements) }} unlocked</div>
                </div>
            </div>

            {{-- ===== BLOG ===== --}}
            @php
                $blogPosts = \App\Models\BlogPost::published()->with('category')->latest('published_at')->take(3)->get();
            @endphp
            @if($blogPosts->isNotEmpty())
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-muted uppercase tracking-widest flex items-center gap-2">
                            <i class="fa-solid fa-newspaper text-indigo-light text-xs"></i> From the blog
                        </h3>
                        <a href="{{ route('blog') }}" class="text-xs text-muted hover:text-indigo-light transition-colors flex items-center gap-1 cursor-pointer">
                            View all <i class="fa-solid fa-arrow-right text-[9px]"></i>
                        </a>
                    </div>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($blogPosts as $post)
                            <a href="{{ route('blog.show', $post) }}" class="glass-card rounded-2xl p-5 group hover:border-{{ $post->category->color }}/15 transition-all duration-500 cursor-pointer">
                                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-{{ $post->category->color }}/10 rounded-full mb-3 text-[10px] font-semibold text-{{ $post->category->color }}-light uppercase tracking-widest">
                                    <i class="{{ $post->category->icon }} text-[8px]"></i>
                                    {{ $post->category->name }}
                                </div>
                                <h4 class="font-display text-sm font-bold text-bright mb-2 group-hover:text-indigo-light transition-colors duration-300 leading-snug">{{ $post->title }}</h4>
                                <p class="text-xs text-muted leading-relaxed line-clamp-2">{{ $post->excerpt }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
    <script>
    function activityChart() {
        return {
            init() {
                const data = @json($weeklyActivity);
                const ctx = this.$refs.chart.getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 128);
                gradient.addColorStop(0, 'rgba(139, 123, 245, 0.25)');
                gradient.addColorStop(1, 'rgba(139, 123, 245, 0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map(d => d.label),
                        datasets: [{
                            data: data.map(d => d.count),
                            borderColor: '#8B7BF5',
                            backgroundColor: gradient,
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointRadius: data.map(d => d.is_today ? 5 : 0),
                            pointBackgroundColor: '#8B7BF5',
                            pointBorderColor: '#0e0e14',
                            pointBorderWidth: 2,
                            pointHoverRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false }, tooltip: {
                            backgroundColor: '#1c1c28', titleColor: '#eeeef6', bodyColor: '#9898b4',
                            borderColor: '#2c2c3c', borderWidth: 1, cornerRadius: 8, padding: 10, displayColors: false,
                            callbacks: { title: (items) => data[items[0].dataIndex].label, label: (item) => item.raw + ' lessons' }
                        }},
                        scales: { x: { display: false }, y: { display: false, beginAtZero: true } },
                        interaction: { intersect: false, mode: 'index' },
                    }
                });
            }
        }
    }
    </script>
@endsection
