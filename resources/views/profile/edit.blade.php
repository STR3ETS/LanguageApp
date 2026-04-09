@extends('layouts.dashboard')

@section('content')
    <div class="py-8 lg:py-10">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="font-display text-2xl font-bold text-bright">{{ __('ui.profile') }}</h1>
                <p class="text-sm text-muted mt-1">Manage your account settings and preferences.</p>
            </div>

            <div class="space-y-5">
                {{-- Account info --}}
                <div class="glass-card rounded-2xl p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-9 h-9 bg-indigo/10 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-user text-indigo-light text-sm"></i>
                        </div>
                        <h2 class="font-display text-base font-bold text-bright">{{ __('ui.account_information') }}</h2>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- Password --}}
                <div class="glass-card rounded-2xl p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-9 h-9 bg-sun/10 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-lock text-sun-light text-sm"></i>
                        </div>
                        <h2 class="font-display text-base font-bold text-bright">{{ __('ui.password') }}</h2>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- Subscription info --}}
                <div class="glass-card rounded-2xl p-6 sm:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-9 h-9 bg-indigo/10 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-crown text-indigo-light text-sm"></i>
                        </div>
                        <h2 class="font-display text-base font-bold text-bright">{{ __('ui.subscription') }}</h2>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-bright font-semibold">{{ __('ui.free_plan') }}</div>
                            <div class="text-xs text-muted mt-0.5">1 language, A1 level</div>
                        </div>
                        <a href="{{ route('pricing') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_20px_var(--color-indigo-glow)] cursor-pointer">
                            <i class="fa-solid fa-crown text-xs"></i> Upgrade to Premium
                        </a>
                    </div>
                </div>

                {{-- Danger zone --}}
                <div class="glass-card rounded-2xl p-6 sm:p-8 border-danger/10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-9 h-9 bg-danger/10 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-triangle-exclamation text-danger text-sm"></i>
                        </div>
                        <h2 class="font-display text-base font-bold text-bright">{{ __('ui.danger_zone') }}</h2>
                    </div>
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
