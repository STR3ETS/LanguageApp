<nav x-data="{ open: false }" class="glass border-b border-border/30 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-1.5 group">
                    <span class="text-lg font-display font-bold tracking-wide text-bright group-hover:text-gradient transition-all duration-300">Fluence</span>
                    <span class="w-1 h-1 rounded-full bg-indigo -mt-2"></span>
                </a>

                <div class="hidden sm:flex items-center gap-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="fa-solid fa-house text-xs mr-1.5 {{ request()->routeIs('dashboard') ? 'text-indigo-light' : 'text-muted' }}"></i>Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('learn.index')" :active="request()->routeIs('learn.*')">
                        <i class="fa-solid fa-graduation-cap text-xs mr-1.5 {{ request()->routeIs('learn.*') ? 'text-indigo-light' : 'text-muted' }}"></i>Learn
                    </x-nav-link>
                    <x-nav-link :href="route('languages.index')" :active="request()->routeIs('languages.*')">
                        <i class="fa-solid fa-globe text-xs mr-1.5 {{ request()->routeIs('languages.*') ? 'text-indigo-light' : 'text-muted' }}"></i>Languages
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-2">
                @if(auth()->user()->streak)
                    <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-elevated/60 text-xs font-semibold">
                        <i class="fa-solid fa-fire-flame-curved text-sun-light text-[11px]"></i>
                        <span class="text-sun-light">{{ auth()->user()->streak->current_streak ?? 0 }}</span>
                    </div>
                    <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-elevated/60 text-xs font-semibold">
                        <i class="fa-solid fa-bolt text-indigo-light text-[11px]"></i>
                        <span class="text-indigo-light">{{ number_format(auth()->user()->streak->total_xp ?? 0) }}</span>
                    </div>
                @endif

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-elevated/60 hover:bg-elevated text-sm font-medium text-soft hover:text-bright transition-all duration-200 cursor-pointer">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo/40 to-sky/30 flex items-center justify-center text-[11px] font-bold text-white/80">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden lg:inline">{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-[8px] text-muted"></i>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-border/30">
                            <div class="text-sm font-semibold text-bright">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-muted">{{ Auth::user()->email }}</div>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fa-solid fa-user-gear text-xs text-muted mr-2"></i>Profile
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('pricing')">
                            <i class="fa-solid fa-crown text-xs text-indigo-light mr-2"></i>Upgrade to Premium
                        </x-dropdown-link>
                        <div class="border-t border-border/30"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fa-solid fa-arrow-right-from-bracket text-xs text-muted mr-2"></i>Log out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-lg text-soft hover:text-bright hover:bg-elevated transition-all duration-200 cursor-pointer">
                    <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden border-t border-border/30">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="fa-solid fa-house text-xs mr-2"></i>Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('learn.index')" :active="request()->routeIs('learn.*')">
                <i class="fa-solid fa-graduation-cap text-xs mr-2"></i>Learn
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('languages.index')" :active="request()->routeIs('languages.*')">
                <i class="fa-solid fa-globe text-xs mr-2"></i>Languages
            </x-responsive-nav-link>
        </div>
        <div class="pt-3 pb-3 border-t border-border/30 px-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo/40 to-sky/30 flex items-center justify-center text-xs font-bold text-white/80">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="text-sm font-semibold text-bright">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-muted">{{ Auth::user()->email }}</div>
                </div>
                @if(auth()->user()->streak)
                    <div class="ml-auto flex items-center gap-2">
                        <span class="flex items-center gap-1 text-xs font-semibold text-sun-light"><i class="fa-solid fa-fire-flame-curved text-[10px]"></i>{{ auth()->user()->streak->current_streak ?? 0 }}</span>
                        <span class="flex items-center gap-1 text-xs font-semibold text-indigo-light"><i class="fa-solid fa-bolt text-[10px]"></i>{{ number_format(auth()->user()->streak->total_xp ?? 0) }}</span>
                    </div>
                @endif
            </div>
            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')"><i class="fa-solid fa-user-gear text-xs mr-2"></i>Profile</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('pricing')"><i class="fa-solid fa-crown text-xs text-indigo-light mr-2"></i>Upgrade</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs mr-2"></i>Log out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
