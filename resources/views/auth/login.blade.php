<x-guest-layout>
    <div class="mb-8">
        <h2 class="font-display text-2xl font-bold text-bright mb-2">Welcome back.</h2>
        <p class="text-sm text-muted">Log in to continue your learning journey.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-envelope text-muted text-xs"></i></div>
                <x-text-input id="email" class="block w-full pl-10" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-5" x-data="{ show: false }">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-lock text-muted text-xs"></i></div>
                <x-text-input id="password" class="block w-full pl-10 pr-11" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Your password" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-muted hover:text-soft transition-colors duration-200 cursor-pointer focus:outline-none">
                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'" class="text-xs"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-5">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-border/50 bg-elevated text-indigo focus:ring-indigo/30 focus:ring-offset-night cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-muted">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-light hover:text-indigo transition-colors duration-200" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full justify-center gap-2">
                Log in
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </x-primary-button>
        </div>

        <div class="relative mt-8">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-border/30"></div></div>
            <div class="relative flex justify-center"><span class="bg-night px-4 text-xs text-muted">or</span></div>
        </div>

        <p class="text-center text-sm text-muted mt-6">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-indigo-light hover:text-indigo font-semibold transition-colors duration-200">Create one <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
        </p>
    </form>
</x-guest-layout>
