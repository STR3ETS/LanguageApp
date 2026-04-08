<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#08080c">

    <title>@yield('title', config('app.name', 'Fluence') . ' - Dashboard')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-night text-text font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">

        {{-- ===== SIDEBAR — desktop: fixed, mobile: overlay ===== --}}

        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sidebarOpen = false" class="fixed inset-0 bg-void/60 z-40 lg:hidden" x-cloak></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-dark border-r border-border/20 flex flex-col transition-transform duration-300 lg:translate-x-0">

            {{-- Logo --}}
            <div class="h-16 flex items-center px-6 border-b border-border/20">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-1.5 group">
                    <span class="text-lg font-display font-bold tracking-wide text-bright group-hover:text-gradient transition-all duration-300">Fluence</span>
                    <span class="w-1 h-1 rounded-full bg-indigo -mt-2"></span>
                </a>
            </div>

            {{-- Navigation --}}
            <nav id="tour-sidebar" class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <div class="text-[10px] text-muted uppercase tracking-widest font-semibold px-3 mb-2">Main</div>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo/10 text-indigo-light' : 'text-soft hover:text-bright hover:bg-elevated/50' }}">
                    <i class="fa-solid fa-house text-xs w-5 text-center {{ request()->routeIs('dashboard') ? 'text-indigo-light' : 'text-muted' }}"></i>
                    Dashboard
                </a>

                <a href="{{ route('learn.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('learn.*') ? 'bg-indigo/10 text-indigo-light' : 'text-soft hover:text-bright hover:bg-elevated/50' }}">
                    <i class="fa-solid fa-graduation-cap text-xs w-5 text-center {{ request()->routeIs('learn.*') ? 'text-indigo-light' : 'text-muted' }}"></i>
                    Learn
                </a>

                <a href="{{ route('languages.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('languages.*') ? 'bg-indigo/10 text-indigo-light' : 'text-soft hover:text-bright hover:bg-elevated/50' }}">
                    <i class="fa-solid fa-globe text-xs w-5 text-center {{ request()->routeIs('languages.*') ? 'text-indigo-light' : 'text-muted' }}"></i>
                    Languages
                </a>

                {{-- Active languages --}}
                @php
                    $sidebarSubs = auth()->user()->subscriptions()->active()->with('language')->get();
                @endphp
                @if($sidebarSubs->isNotEmpty())
                    <div class="text-[10px] text-muted uppercase tracking-widest font-semibold px-3 mt-6 mb-2">Your languages</div>

                    @foreach($sidebarSubs as $sub)
                        <a href="{{ route('learn.language', $sub->language->slug) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->is('learn/' . $sub->language->slug) ? 'bg-indigo/10 text-indigo-light' : 'text-soft hover:text-bright hover:bg-elevated/50' }}">
                            <div class="w-5 flex justify-center">
                                <x-flag :code="$sub->language->flag_code" size="sm" />
                            </div>
                            {{ $sub->language->name }}
                        </a>
                    @endforeach
                @endif

                <div class="text-[10px] text-muted uppercase tracking-widest font-semibold px-3 mt-6 mb-2">Account</div>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('profile.*') ? 'bg-indigo/10 text-indigo-light' : 'text-soft hover:text-bright hover:bg-elevated/50' }}">
                    <i class="fa-solid fa-user-gear text-xs w-5 text-center {{ request()->routeIs('profile.*') ? 'text-indigo-light' : 'text-muted' }}"></i>
                    Profile
                </a>

                <a href="{{ route('pricing') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-soft hover:text-bright hover:bg-elevated/50 transition-all duration-200">
                    <i class="fa-solid fa-crown text-xs w-5 text-center text-indigo-light"></i>
                    Upgrade
                </a>

                <div class="border-t border-border/20 mt-4 pt-4">
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-soft hover:text-bright hover:bg-elevated/50 transition-all duration-200">
                            <i class="fa-solid fa-shield-halved text-xs w-5 text-center text-rose-light"></i>
                            Admin panel
                        </a>
                    @endif
                    <a href="{{ url('/') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-soft hover:text-bright hover:bg-elevated/50 transition-all duration-200">
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs w-5 text-center text-muted"></i>
                        Back to website
                    </a>
                </div>
            </nav>

            {{-- Streak + XP bar --}}
            @if(auth()->user()->streak)
                <div class="px-4 py-3 border-t border-border/20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-1.5 text-xs font-semibold">
                            <i class="fa-solid fa-fire-flame-curved text-sun-light text-[11px]"></i>
                            <span class="text-sun-light">{{ auth()->user()->streak->current_streak ?? 0 }} days</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs font-semibold">
                            <i class="fa-solid fa-bolt text-indigo-light text-[11px]"></i>
                            <span class="text-indigo-light">{{ number_format(auth()->user()->streak->total_xp ?? 0) }} XP</span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Premium CTA --}}
            <div class="px-4 py-3 border-t border-border/20">
                <a href="{{ route('pricing') }}" class="flex items-center gap-3 px-3 py-3 bg-indigo/10 hover:bg-indigo/15 rounded-xl transition-all duration-200 cursor-pointer group">
                    <div class="w-8 h-8 bg-indigo/15 rounded-lg flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-crown text-indigo-light text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-xs font-semibold text-indigo-light">Get Premium</div>
                        <div class="text-[10px] text-muted">All languages & levels</div>
                    </div>
                    <i class="fa-solid fa-arrow-right text-[9px] text-indigo-light/50 group-hover:text-indigo-light group-hover:translate-x-0.5 transition-all duration-200"></i>
                </a>
            </div>

            {{-- User --}}
            <div class="px-4 py-4 border-t border-border/20">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 group cursor-pointer">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo/40 to-sky/30 flex items-center justify-center text-xs font-bold text-white/80 shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-semibold text-bright truncate group-hover:text-indigo-light transition-colors duration-200">{{ Auth::user()->name }}</div>
                        <div class="text-[11px] text-muted truncate">{{ Auth::user()->email }}</div>
                    </div>
                </a>
            </div>
        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <div class="flex-1 flex flex-col min-w-0 lg:ml-64">

            {{-- Top bar (mobile hamburger + breadcrumb) --}}
            <header class="h-16 flex items-center gap-4 px-6 border-b border-border/20 lg:border-0 shrink-0">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 text-soft hover:text-bright hover:bg-elevated rounded-lg transition-all duration-200 cursor-pointer">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="text-sm text-muted">
                    @yield('breadcrumb')
                </div>
            </header>

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto">
                @yield('content')
                @isset($slot) {{ $slot }} @endisset
            </main>
        </div>
    </div>
</body>
</html>
