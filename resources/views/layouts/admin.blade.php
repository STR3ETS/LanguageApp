<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - Fluence')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-night text-text font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">

        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sidebarOpen = false" class="fixed inset-0 bg-void/60 z-40 lg:hidden" x-cloak></div>

        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-dark border-r border-border/20 flex flex-col transition-transform duration-300 lg:translate-x-0">

            <div class="h-16 flex items-center justify-between px-6 border-b border-border/20">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1.5">
                    <span class="text-lg font-display font-bold tracking-wide text-bright">Fluence</span>
                    <span class="text-[9px] px-1.5 py-0.5 bg-rose/10 text-rose-light rounded font-semibold ml-1">ADMIN</span>
                </a>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                <div class="text-[10px] text-muted uppercase tracking-widest font-semibold px-3 mb-2">Overview</div>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo/10 text-indigo-light' : 'text-soft hover:text-bright hover:bg-elevated/50' }}">
                    <i class="fa-solid fa-chart-pie text-xs w-5 text-center"></i>
                    Dashboard
                </a>

                <div class="text-[10px] text-muted uppercase tracking-widest font-semibold px-3 mt-6 mb-2">Management</div>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-indigo/10 text-indigo-light' : 'text-soft hover:text-bright hover:bg-elevated/50' }}">
                    <i class="fa-solid fa-users text-xs w-5 text-center"></i>
                    Users
                </a>

                <a href="{{ route('admin.languages.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.languages.*') ? 'bg-indigo/10 text-indigo-light' : 'text-soft hover:text-bright hover:bg-elevated/50' }}">
                    <i class="fa-solid fa-globe text-xs w-5 text-center"></i>
                    Languages
                </a>

                <a href="{{ route('admin.blog.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.blog.*') ? 'bg-indigo/10 text-indigo-light' : 'text-soft hover:text-bright hover:bg-elevated/50' }}">
                    <i class="fa-solid fa-newspaper text-xs w-5 text-center"></i>
                    Blog Posts
                </a>

                <div class="border-t border-border/20 mt-6 pt-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-soft hover:text-bright hover:bg-elevated/50 transition-all duration-200">
                        <i class="fa-solid fa-arrow-left text-xs w-5 text-center"></i>
                        Back to app
                    </a>
                    <a href="{{ url('/') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-soft hover:text-bright hover:bg-elevated/50 transition-all duration-200">
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs w-5 text-center"></i>
                        View website
                    </a>
                </div>
            </nav>

            <div class="px-4 py-4 border-t border-border/20">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-rose/40 to-indigo/30 flex items-center justify-center text-xs font-bold text-white/80 shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-semibold text-bright truncate">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-rose-light">Administrator</div>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col min-w-0 lg:ml-64">
            <header class="h-16 flex items-center gap-4 px-6 border-b border-border/20 lg:border-0 shrink-0">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 text-soft hover:text-bright hover:bg-elevated rounded-lg transition-all duration-200 cursor-pointer">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="text-sm text-muted">@yield('breadcrumb')</div>
            </header>

            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
