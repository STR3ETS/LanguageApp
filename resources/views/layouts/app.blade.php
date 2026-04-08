<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#08080c">

    <title>@yield('title', config('app.name', 'Fluence') . ' - Unlock the way you learn')</title>
    <meta name="description" content="@yield('meta_description', 'Learn a language through levels, rewards and short daily wins.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-night text-text font-sans antialiased">
        <!-- Top Bar -->
        <div class="fixed top-0 w-full z-50 bg-elevated/80 border-b border-border/20 hidden md:block">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-8">
                    <div class="flex items-center gap-5">
                        <a href="mailto:hello@fluence.com" class="flex items-center gap-1.5 text-[11px] text-muted hover:text-indigo-light transition-colors duration-200">
                            <i class="fa-solid fa-envelope text-[9px]"></i>
                            hello@fluence.com
                        </a>
                        <a href="tel:+31612345678" class="flex items-center gap-1.5 text-[11px] text-muted hover:text-indigo-light transition-colors duration-200">
                            <i class="fa-solid fa-phone text-[9px]"></i>
                            +31 6 1234 5678
                        </a>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('contact') }}" class="text-[11px] text-muted hover:text-indigo-light transition-colors duration-200">Help Center</a>
                        <a href="{{ route('blog') }}" class="text-[11px] text-muted hover:text-indigo-light transition-colors duration-200">Blog</a>
                        <div class="flex items-center gap-3 ml-2 pl-3 border-l border-border/30">
                            <a href="#" class="text-muted hover:text-indigo-light transition-colors duration-200"><i class="fa-brands fa-instagram text-xs"></i></a>
                            <a href="#" class="text-muted hover:text-indigo-light transition-colors duration-200"><i class="fa-brands fa-x-twitter text-xs"></i></a>
                            <a href="#" class="text-muted hover:text-indigo-light transition-colors duration-200"><i class="fa-brands fa-linkedin text-xs"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Public Navigation -->
        <nav class="fixed top-0 md:top-8 w-full z-50 transition-all duration-300" x-data="{ mobileOpen: false, scrolled: false }" x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })" :class="scrolled ? 'glass' : 'bg-transparent border-transparent'">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                        <span class="text-xl font-display font-bold tracking-wide text-bright group-hover:text-gradient transition-all duration-300">Fluence</span>
                        <span class="w-1 h-1 rounded-full bg-indigo -mt-3 group-hover:shadow-[0_0_8px_var(--color-indigo)] transition-shadow duration-300"></span>
                    </a>

                    <div class="hidden md:flex items-center gap-8">
                        <a href="{{ route('languages.index') }}" class="text-sm font-medium text-soft hover:text-bright transition-colors duration-200">Languages</a>
                        <a href="{{ route('how-it-works') }}" class="text-sm font-medium text-soft hover:text-bright transition-colors duration-200">How it works</a>
                        <a href="{{ route('pricing') }}" class="text-sm font-medium text-soft hover:text-bright transition-colors duration-200">Pricing</a>
                        <a href="{{ route('about') }}" class="text-sm font-medium text-soft hover:text-bright transition-colors duration-200">About</a>
                        <a href="{{ route('contact') }}" class="text-sm font-medium text-soft hover:text-bright transition-colors duration-200">Contact</a>
                    </div>

                    <div class="flex items-center gap-4">
                        @auth
                            {{-- Logged in: dashboard link + profile --}}
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-soft hover:text-bright transition-colors duration-200 hidden sm:flex">
                                <i class="fa-solid fa-grid-2 text-xs text-indigo-light"></i> Dashboard
                            </a>
                            <div class="relative hidden sm:block" x-data="{ profileOpen: false }" @click.away="profileOpen = false">
                                <button @click="profileOpen = !profileOpen" class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-elevated/60 hover:bg-elevated text-sm font-medium text-soft hover:text-bright transition-all duration-200 cursor-pointer">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo/40 to-sky/30 flex items-center justify-center text-[11px] font-bold text-white/80">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span class="hidden lg:inline">{{ Auth::user()->name }}</span>
                                    <i class="fa-solid fa-chevron-down text-[8px] text-muted"></i>
                                </button>
                                <div x-show="profileOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute right-0 mt-2 w-48 glass rounded-xl overflow-hidden py-1 shadow-lg" x-cloak>
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 text-sm text-soft hover:text-bright hover:bg-elevated/60 transition-colors duration-150">
                                        <i class="fa-solid fa-grid-2 text-xs text-muted mr-2"></i>Dashboard
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-soft hover:text-bright hover:bg-elevated/60 transition-colors duration-150">
                                        <i class="fa-solid fa-user-gear text-xs text-muted mr-2"></i>Profile
                                    </a>
                                    <div class="border-t border-border/20 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-soft hover:text-bright hover:bg-elevated/60 transition-colors duration-150 cursor-pointer">
                                            <i class="fa-solid fa-arrow-right-from-bracket text-xs text-muted mr-2"></i>Log out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            {{-- Language selector --}}
                            <div class="relative hidden sm:block" x-data="{ langOpen: false }" @click.away="langOpen = false">
                                <button @click="langOpen = !langOpen" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-soft hover:text-bright transition-colors duration-200 cursor-pointer">
                                    <i class="fa-solid fa-globe text-xs text-indigo-light"></i>
                                    <span class="text-sm font-medium">EN</span>
                                    <i class="fa-solid fa-chevron-down text-[8px] text-muted transition-transform duration-200" :class="langOpen && 'rotate-180'"></i>
                                </button>
                                <div x-show="langOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute right-0 mt-2 w-36 glass rounded-xl overflow-hidden py-1 shadow-lg" x-cloak>
                                    @foreach([
                                        ['code' => 'en', 'label' => 'English'],
                                        ['code' => 'nl', 'label' => 'Nederlands'],
                                        ['code' => 'de', 'label' => 'Deutsch'],
                                        ['code' => 'fr', 'label' => 'Français'],
                                        ['code' => 'es', 'label' => 'Español'],
                                    ] as $locale)
                                        <button class="w-full text-left px-4 py-2 text-sm {{ $locale['code'] === 'en' ? 'text-indigo-light font-semibold' : 'text-soft' }} hover:bg-elevated/60 hover:text-bright transition-colors duration-150 flex items-center justify-between cursor-pointer">
                                            {{ $locale['label'] }}
                                            @if($locale['code'] === 'en')
                                                <i class="fa-solid fa-check text-[9px] text-indigo-light"></i>
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <a href="{{ route('login') }}" class="text-sm font-medium text-soft hover:text-bright transition-colors duration-200 hidden sm:block">Log in</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_20px_var(--color-indigo-glow)]">
                                Start today
                            </a>
                        @endauth
                    </div>

                    <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-soft hover:text-bright transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>

                <!-- Mobile menu -->
                <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="md:hidden pb-4 space-y-1" x-cloak>
                    <a href="{{ route('languages.index') }}" class="block py-2.5 text-sm font-medium text-soft hover:text-bright">Languages</a>
                    <a href="{{ route('how-it-works') }}" class="block py-2.5 text-sm font-medium text-soft hover:text-bright">How it works</a>
                    <a href="{{ route('pricing') }}" class="block py-2.5 text-sm font-medium text-soft hover:text-bright">Pricing</a>
                    <a href="{{ route('about') }}" class="block py-2.5 text-sm font-medium text-soft hover:text-bright">About</a>
                    <a href="{{ route('blog') }}" class="block py-2.5 text-sm font-medium text-soft hover:text-bright">Blog</a>
                    <a href="{{ route('contact') }}" class="block py-2.5 text-sm font-medium text-soft hover:text-bright">Contact</a>
                    <div class="border-t border-border/20 mt-2 pt-2">
                        @auth
                            <a href="{{ route('dashboard') }}" class="block py-2.5 text-sm font-medium text-soft hover:text-bright">Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="block py-2.5 text-sm font-medium text-soft hover:text-bright">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block py-2.5 text-sm font-medium text-soft hover:text-bright cursor-pointer w-full text-left">Log out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block py-2.5 text-sm font-medium text-soft hover:text-bright">Log in</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

    <main class="pt-16 md:pt-24">
        @yield('content')
        @isset($slot) {{ $slot }} @endisset
    </main>

    <footer class="bg-dark">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 pt-16 pb-10">

            {{-- Top section: brand + newsletter --}}
            <div class="grid md:grid-cols-2 gap-10 mb-14">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-2xl font-display font-bold tracking-wide text-bright">Fluence</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo -mt-4"></span>
                    </div>
                    <p class="text-sm text-soft leading-relaxed max-w-sm mb-5">Master a new language with elegant, bite-sized lessons. Built for learners who value consistency and quality.</p>
                    <div class="flex items-center gap-4">
                        <a href="#" class="w-9 h-9 rounded-full bg-elevated flex items-center justify-center text-muted hover:text-indigo-light hover:bg-indigo/10 transition-all duration-200"><i class="fa-brands fa-instagram text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-elevated flex items-center justify-center text-muted hover:text-indigo-light hover:bg-indigo/10 transition-all duration-200"><i class="fa-brands fa-x-twitter text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-elevated flex items-center justify-center text-muted hover:text-indigo-light hover:bg-indigo/10 transition-all duration-200"><i class="fa-brands fa-linkedin text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-elevated flex items-center justify-center text-muted hover:text-indigo-light hover:bg-indigo/10 transition-all duration-200"><i class="fa-brands fa-tiktok text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-elevated flex items-center justify-center text-muted hover:text-indigo-light hover:bg-indigo/10 transition-all duration-200"><i class="fa-brands fa-youtube text-sm"></i></a>
                    </div>
                </div>
                <div class="md:text-right md:flex md:flex-col md:items-end md:justify-center">
                    <h4 class="text-sm font-semibold text-bright mb-3">Stay in the loop</h4>
                    <p class="text-xs text-muted mb-4">Tips, updates and new languages — straight to your inbox.</p>
                    <form class="flex gap-2 w-full max-w-sm">
                        <input type="email" placeholder="Your email address" class="flex-1 px-4 py-2.5 bg-elevated border border-border/50 rounded-full text-sm text-text placeholder-muted focus:outline-none focus:border-indigo/40 transition-colors duration-200">
                        <button type="submit" class="px-5 py-2.5 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_20px_var(--color-indigo-glow)]">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-border/20 pt-12"></div>

            {{-- Link columns --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-8 mb-14">
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-widest text-muted mb-4">Product</h4>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('languages.index') }}" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Languages</a></li>
                        <li><a href="{{ route('pricing') }}" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Pricing</a></li>
                        <li><a href="{{ route('how-it-works') }}" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">How it works</a></li>
                        <li><a href="#" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Free plan</a></li>
                        <li><a href="#" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Premium</a></li>
                        <li><a href="#" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Family plan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-widest text-muted mb-4">Languages</h4>
                    <ul class="space-y-2.5">
                        <li><a href="#" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Dutch</a></li>
                        <li><a href="#" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">German</a></li>
                        <li><a href="#" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">French</a></li>
                        <li><a href="#" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Spanish</a></li>
                        <li><a href="#" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Japanese</a></li>
                        <li><a href="{{ route('languages.index') }}" class="text-sm text-indigo-light hover:text-indigo transition-colors duration-200">View all &rarr;</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-widest text-muted mb-4">Company</h4>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('about') }}" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">About us</a></li>
                        <li><a href="{{ route('blog') }}" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Blog</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Careers</a></li>
                        <li><a href="{{ route('about') }}" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Press</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-widest text-muted mb-4">Support</h4>
                    <ul class="space-y-2.5">
                        <li><a href="{{ route('contact') }}" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Help Center</a></li>
                        <li><a href="{{ route('contact') }}" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Contact us</a></li>
                        <li><a href="#" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">FAQ</a></li>
                        <li><a href="#" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Status</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-widest text-muted mb-4">Legal</h4>
                    <ul class="space-y-2.5">
                        <li><a href="#" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Privacy Policy</a></li>
                        <li><a href="#" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Terms of Service</a></li>
                        <li><a href="#" class="text-sm text-soft hover:text-indigo-light transition-colors duration-200">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>

            {{-- Contact bar --}}
            <div class="border-t border-border/20 pt-8 mb-8">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-8">
                        <a href="mailto:hello@fluence.com" class="flex items-center gap-2 text-sm text-soft hover:text-indigo-light transition-colors duration-200">
                            <i class="fa-solid fa-envelope text-xs text-muted"></i>
                            hello@fluence.com
                        </a>
                        <a href="tel:+31612345678" class="flex items-center gap-2 text-sm text-soft hover:text-indigo-light transition-colors duration-200">
                            <i class="fa-solid fa-phone text-xs text-muted"></i>
                            +31 6 1234 5678
                        </a>
                    </div>
                    <div class="flex items-center gap-3">
                        <img src="https://flagcdn.com/w20/nl.png" alt="NL" class="w-4 h-3 rounded-sm opacity-60">
                        <span class="text-xs text-muted">Based in the Netherlands</span>
                    </div>
                </div>
            </div>

            {{-- Bottom bar --}}
            <div class="border-t border-border/20 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-muted">&copy; {{ date('Y') }} Fluence. All rights reserved.</p>
                <div class="flex items-center gap-5">
                    <a href="#" class="text-xs text-muted hover:text-soft transition-colors duration-200">Privacy</a>
                    <a href="#" class="text-xs text-muted hover:text-soft transition-colors duration-200">Terms</a>
                    <a href="#" class="text-xs text-muted hover:text-soft transition-colors duration-200">Cookies</a>
                    <a href="#" class="text-xs text-muted hover:text-soft transition-colors duration-200">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
