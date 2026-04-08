@extends('layouts.admin')

@section('title', $user->name . ' - Admin')

@section('content')
<div class="py-8">
    <div class="max-w-5xl mx-auto px-6 lg:px-8">

        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-muted hover:text-indigo-light transition-colors mb-6 cursor-pointer">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to users
        </a>

        @if(session('success'))
            <div class="mb-6 px-5 py-3 glass-card rounded-xl border-mint/20 text-sm text-mint-light flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        {{-- User header --}}
        <div class="glass-card rounded-2xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo/30 to-sky/20 flex items-center justify-center text-xl font-bold text-white/70">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="font-display text-xl font-bold text-bright">{{ $user->name }}</h1>
                            @if($user->is_admin)
                                <span class="text-[10px] px-2 py-0.5 bg-rose/10 text-rose-light rounded-full font-semibold">Admin</span>
                            @endif
                        </div>
                        <div class="text-sm text-muted">{{ $user->email }}</div>
                        <div class="text-xs text-muted mt-1">Joined {{ $user->created_at->format('M j, Y') }} · {{ $user->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-xs font-semibold rounded-xl transition-all cursor-pointer {{ $user->is_admin ? 'bg-elevated text-muted hover:text-bright' : 'bg-rose/10 text-rose-light hover:bg-rose/20' }}">
                            {{ $user->is_admin ? 'Remove admin' : 'Make admin' }}
                        </button>
                    </form>
                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user permanently?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-danger/10 text-danger text-xs font-semibold rounded-xl hover:bg-danger/20 transition-all cursor-pointer">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @foreach([
                ['label' => 'Streak', 'value' => $user->streak?->current_streak ?? 0, 'icon' => 'fa-fire-flame-curved', 'color' => 'sun'],
                ['label' => 'Total XP', 'value' => number_format($user->streak?->total_xp ?? 0), 'icon' => 'fa-bolt', 'color' => 'indigo'],
                ['label' => 'Languages', 'value' => $user->subscriptions->count(), 'icon' => 'fa-globe', 'color' => 'sky'],
                ['label' => 'Best streak', 'value' => $user->streak?->longest_streak ?? 0, 'icon' => 'fa-trophy', 'color' => 'mint'],
            ] as $stat)
                <div class="glass-card rounded-2xl p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fa-solid {{ $stat['icon'] }} text-{{ $stat['color'] }}-light text-xs"></i>
                        <span class="text-[10px] text-muted uppercase tracking-widest">{{ $stat['label'] }}</span>
                    </div>
                    <div class="text-xl font-display font-bold text-bright">{{ $stat['value'] }}</div>
                </div>
            @endforeach
        </div>

        {{-- Subscriptions --}}
        <div class="glass-card rounded-2xl p-6 mb-6">
            <h2 class="text-sm font-semibold text-bright mb-4"><i class="fa-solid fa-language text-indigo-light text-xs mr-2"></i>Active languages</h2>
            @if($user->subscriptions->isNotEmpty())
                <div class="space-y-2">
                    @foreach($user->subscriptions as $sub)
                        <div class="flex items-center justify-between py-2 px-3 bg-elevated/40 rounded-xl">
                            <div class="flex items-center gap-3">
                                <x-flag :code="$sub->language->flag_code" size="sm" />
                                <span class="text-sm text-bright">{{ $sub->language->name }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-xs text-muted">
                                <span class="px-2 py-0.5 bg-{{ $sub->status === 'active' ? 'mint' : 'danger' }}/10 text-{{ $sub->status === 'active' ? 'mint' : 'danger' }}-light rounded-full font-semibold text-[10px]">{{ ucfirst($sub->status) }}</span>
                                <span>Since {{ $sub->starts_at?->format('M j, Y') ?? $sub->created_at->format('M j, Y') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-muted">No active subscriptions.</p>
            @endif
        </div>

        {{-- Recent progress --}}
        <div class="glass-card rounded-2xl p-6">
            <h2 class="text-sm font-semibold text-bright mb-4"><i class="fa-solid fa-clock-rotate-left text-sun-light text-xs mr-2"></i>Recent activity</h2>
            @if($progress->isNotEmpty())
                <div class="space-y-2">
                    @foreach($progress as $p)
                        <div class="flex items-center justify-between py-2 px-3 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 bg-mint/10 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-check text-mint-light text-[9px]"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-bright">{{ $p->lesson->title }}</div>
                                    <div class="text-[10px] text-muted">{{ $p->lesson->level->name }} · {{ $p->lesson->level->language->name }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-bright">{{ $p->score }}% · +{{ $p->xp_earned }} XP</div>
                                <div class="text-[10px] text-muted">{{ $p->completed_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-muted">No activity yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
