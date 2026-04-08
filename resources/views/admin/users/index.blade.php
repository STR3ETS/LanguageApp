@extends('layouts.admin')

@section('title', 'Users - Admin')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-display text-2xl font-bold text-bright">Users</h1>
                <p class="text-sm text-muted mt-1">{{ $users->total() }} total users</p>
            </div>
            <form class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." class="px-4 py-2 bg-elevated border border-border/50 rounded-xl text-sm text-text placeholder-muted focus:outline-none focus:border-indigo/40 w-64">
                <button type="submit" class="px-4 py-2 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-xl transition-all cursor-pointer">Search</button>
            </form>
        </div>

        @if(session('success'))
            <div class="mb-6 px-5 py-3 glass-card rounded-xl border-mint/20 text-sm text-mint-light flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="glass-card rounded-2xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-border/30">
                        <th class="text-left p-4 text-muted font-medium text-xs uppercase tracking-widest">User</th>
                        <th class="text-left p-4 text-muted font-medium text-xs uppercase tracking-widest hidden md:table-cell">Languages</th>
                        <th class="text-left p-4 text-muted font-medium text-xs uppercase tracking-widest hidden md:table-cell">Lessons</th>
                        <th class="text-left p-4 text-muted font-medium text-xs uppercase tracking-widest hidden lg:table-cell">XP</th>
                        <th class="text-left p-4 text-muted font-medium text-xs uppercase tracking-widest hidden lg:table-cell">Streak</th>
                        <th class="text-left p-4 text-muted font-medium text-xs uppercase tracking-widest">Role</th>
                        <th class="text-left p-4 text-muted font-medium text-xs uppercase tracking-widest">Joined</th>
                        <th class="p-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/20">
                    @foreach($users as $user)
                        <tr class="hover:bg-elevated/30 transition-colors">
                            <td class="p-4">
                                <a href="{{ route('admin.users.show', $user) }}" class="flex items-center gap-3 cursor-pointer">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo/30 to-sky/20 flex items-center justify-center text-[10px] font-bold text-white/70 shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-bright hover:text-indigo-light transition-colors">{{ $user->name }}</div>
                                        <div class="text-[11px] text-muted">{{ $user->email }}</div>
                                    </div>
                                </a>
                            </td>
                            <td class="p-4 hidden md:table-cell text-muted">{{ $user->subscriptions_count }}</td>
                            <td class="p-4 hidden md:table-cell text-muted">{{ $user->progress_count }}</td>
                            <td class="p-4 hidden lg:table-cell text-muted">{{ number_format($user->streak?->total_xp ?? 0) }}</td>
                            <td class="p-4 hidden lg:table-cell">
                                <span class="flex items-center gap-1 text-sun-light text-xs"><i class="fa-solid fa-fire-flame-curved text-[10px]"></i>{{ $user->streak?->current_streak ?? 0 }}</span>
                            </td>
                            <td class="p-4">
                                @if($user->is_admin)
                                    <span class="text-[10px] px-2 py-0.5 bg-rose/10 text-rose-light rounded-full font-semibold">Admin</span>
                                @else
                                    <span class="text-[10px] px-2 py-0.5 bg-elevated text-muted rounded-full">User</span>
                                @endif
                            </td>
                            <td class="p-4 text-xs text-muted">{{ $user->created_at->format('M j, Y') }}</td>
                            <td class="p-4">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-xs text-indigo-light hover:text-indigo cursor-pointer">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $users->links() }}</div>
    </div>
</div>
@endsection
