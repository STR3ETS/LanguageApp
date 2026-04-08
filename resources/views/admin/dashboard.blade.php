@extends('layouts.admin')

@section('title', 'Admin Dashboard - Fluence')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="font-display text-2xl font-bold text-bright">Dashboard</h1>
            <p class="text-sm text-muted mt-1">Overview of your platform.</p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            @foreach([
                ['label' => 'Total users', 'value' => number_format($stats['total_users']), 'icon' => 'fa-users', 'color' => 'indigo', 'sub' => '+' . $stats['new_users_week'] . ' this week'],
                ['label' => 'Active subscriptions', 'value' => number_format($stats['total_subscriptions']), 'icon' => 'fa-credit-card', 'color' => 'mint', 'sub' => $stats['total_languages'] . ' languages'],
                ['label' => 'Lessons completed', 'value' => number_format($stats['total_lessons_completed']), 'icon' => 'fa-check-double', 'color' => 'sun', 'sub' => $stats['total_levels'] . ' total levels'],
                ['label' => 'Blog posts', 'value' => $stats['total_blog_posts'], 'icon' => 'fa-newspaper', 'color' => 'sky', 'sub' => 'Published'],
            ] as $card)
                <div class="glass-card rounded-2xl p-5">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-{{ $card['color'] }}/10 rounded-xl flex items-center justify-center">
                            <i class="fa-solid {{ $card['icon'] }} text-{{ $card['color'] }}-light text-sm"></i>
                        </div>
                        <span class="text-xs text-muted uppercase tracking-widest">{{ $card['label'] }}</span>
                    </div>
                    <div class="text-2xl font-display font-bold text-bright">{{ $card['value'] }}</div>
                    <div class="text-[10px] text-muted mt-1">{{ $card['sub'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="grid lg:grid-cols-3 gap-6 mb-8">
            {{-- Registrations chart --}}
            <div class="lg:col-span-2 glass-card rounded-2xl p-6">
                <h3 class="text-sm font-semibold text-bright mb-4"><i class="fa-solid fa-chart-line text-indigo-light text-xs mr-2"></i>User registrations (30 days)</h3>
                <div class="h-40" x-data="adminChart()" x-init="init()">
                    <canvas x-ref="chart" class="w-full h-full"></canvas>
                </div>
            </div>

            {{-- Popular languages --}}
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-sm font-semibold text-bright mb-4"><i class="fa-solid fa-globe text-sky-light text-xs mr-2"></i>Popular languages</h3>
                <div class="space-y-3">
                    @foreach($popularLanguages as $lang)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <x-flag :code="$lang->flag_code" size="sm" />
                                <span class="text-sm text-bright">{{ $lang->name }}</span>
                            </div>
                            <span class="text-xs text-indigo-light font-semibold">{{ $lang->subscriptions_count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            {{-- Recent users --}}
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-bright"><i class="fa-solid fa-user-plus text-mint-light text-xs mr-2"></i>Recent users</h3>
                    <a href="{{ route('admin.users.index') }}" class="text-xs text-indigo-light hover:text-indigo cursor-pointer">View all</a>
                </div>
                <div class="space-y-2">
                    @foreach($recentUsers as $user)
                        <a href="{{ route('admin.users.show', $user) }}" class="flex items-center justify-between py-2 px-3 rounded-xl hover:bg-elevated/40 transition-colors cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo/30 to-sky/20 flex items-center justify-center text-[10px] font-bold text-white/70">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-sm text-bright">{{ $user->name }}</div>
                                    <div class="text-[10px] text-muted">{{ $user->email }}</div>
                                </div>
                            </div>
                            <div class="text-[10px] text-muted">{{ $user->created_at->diffForHumans() }}</div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Recent activity --}}
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-sm font-semibold text-bright mb-4"><i class="fa-solid fa-bolt text-sun-light text-xs mr-2"></i>Recent activity</h3>
                <div class="space-y-2">
                    @foreach($recentActivity as $activity)
                        <div class="flex items-center justify-between py-2 px-3 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-mint/10 flex items-center justify-center">
                                    <i class="fa-solid fa-check text-mint-light text-[9px]"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-bright">{{ $activity->user->name }}</div>
                                    <div class="text-[10px] text-muted">{{ $activity->lesson->title }} · {{ $activity->lesson->level->language->name }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-[10px] text-indigo-light font-semibold">+{{ $activity->xp_earned }} XP</div>
                                <div class="text-[10px] text-muted">{{ $activity->completed_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
function adminChart() {
    return {
        init() {
            const data = @json($registrations);
            const ctx = this.$refs.chart.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 160);
            gradient.addColorStop(0, 'rgba(139, 123, 245, 0.25)');
            gradient.addColorStop(1, 'rgba(139, 123, 245, 0)');

            new Chart(ctx, {
                type: 'line',
                data: { labels: data.map(d => d.date), datasets: [{ data: data.map(d => d.count), borderColor: '#8B7BF5', backgroundColor: gradient, borderWidth: 2, fill: true, tension: 0.4, pointRadius: 0, pointHoverRadius: 5 }] },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1c1c28', titleColor: '#eeeef6', bodyColor: '#9898b4', borderColor: '#2c2c3c', borderWidth: 1, cornerRadius: 8, padding: 10, displayColors: false } }, scales: { x: { display: false }, y: { display: false, beginAtZero: true } }, interaction: { intersect: false, mode: 'index' } }
            });
        }
    }
}
</script>
@endsection
