<x-guest-layout>
    <h2 class="text-2xl font-extrabold text-bright mb-1">Reset your password</h2>
    <p class="text-sm text-muted mb-8">Enter your email and we'll send you a reset link.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-8">
            <x-primary-button class="w-full justify-center">Send reset link</x-primary-button>
        </div>

        <p class="text-center text-sm text-muted mt-6">
            <a href="{{ route('login') }}" class="text-indigo-light hover:text-indigo font-medium transition-colors duration-200">Back to login</a>
        </p>
    </form>
</x-guest-layout>
