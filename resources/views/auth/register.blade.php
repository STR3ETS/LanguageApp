<x-guest-layout>
    <div x-data="{
        step: 1,
        language_id: '',
        language_name: '',
        goal: '',
        totalSteps: 3,
        next() { if (this.step < this.totalSteps) this.step++ },
        prev() { if (this.step > 1) this.step-- },
        selectLanguage(id, name) { this.language_id = id; this.language_name = name; }
    }">

        {{-- Progress bar --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs text-muted">Step <span x-text="step"></span> of <span x-text="totalSteps"></span></span>
                <span class="text-xs text-indigo-light font-semibold" x-text="step === 1 ? 'Choose language' : (step === 2 ? 'Your goal' : 'Create account')"></span>
            </div>
            <div class="w-full bg-elevated rounded-full h-1.5">
                <div class="bg-gradient-to-r from-indigo to-indigo-light rounded-full h-1.5 transition-all duration-500" :style="'width: ' + (step / totalSteps * 100) + '%'"></div>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="hidden" name="language_id" x-model="language_id">
            <input type="hidden" name="goal" x-model="goal">

            {{-- ===== STEP 1: Choose language ===== --}}
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="mb-6">
                    <h2 class="font-display text-2xl font-bold text-bright mb-2">What do you want to learn?</h2>
                    <p class="text-sm text-muted">Pick the language you'd like to start with. You can always change or add more later.</p>
                </div>

                <div class="grid grid-cols-3 gap-2.5 mb-6">
                    @foreach($languages as $lang)
                        <button type="button"
                            @click="selectLanguage({{ $lang->id }}, '{{ $lang->name }}')"
                            :class="language_id == {{ $lang->id }} ? 'border-indigo/50 bg-indigo/10 ring-1 ring-indigo/30' : 'border-border/30 bg-elevated/50 hover:border-indigo/20 hover:bg-elevated'"
                            class="border rounded-2xl p-3 text-center transition-all duration-200 cursor-pointer focus:outline-none group">
                            <div class="mb-1.5 group-hover:scale-110 transition-transform duration-200">
                                <x-flag :code="$lang->flag_code" size="md" class="mx-auto" />
                            </div>
                            <div class="text-[11px] font-medium" :class="language_id == {{ $lang->id }} ? 'text-indigo-light' : 'text-soft'">{{ $lang->name }}</div>
                        </button>
                    @endforeach
                </div>

                <button type="button" @click="next()" :disabled="!language_id"
                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_30px_var(--color-indigo-glow)] cursor-pointer disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:shadow-none disabled:hover:bg-indigo">
                    Continue
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>

            {{-- ===== STEP 2: Goal ===== --}}
            <div x-show="step === 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                <div class="mb-6">
                    <h2 class="font-display text-2xl font-bold text-bright mb-2">What's your goal?</h2>
                    <p class="text-sm text-muted">This helps us personalize your experience. You're learning <span class="text-indigo-light font-semibold" x-text="language_name"></span>.</p>
                </div>

                <div class="space-y-2.5 mb-6">
                    @foreach([
                        ['value' => 'travel', 'icon' => 'fa-plane', 'label' => 'Travel', 'desc' => 'I want to get by on my next trip', 'color' => 'sky'],
                        ['value' => 'career', 'icon' => 'fa-briefcase', 'label' => 'Career', 'desc' => 'I need it for work or my resume', 'color' => 'indigo'],
                        ['value' => 'culture', 'icon' => 'fa-masks-theater', 'label' => 'Culture', 'desc' => 'I want to enjoy media, music, or books', 'color' => 'sun'],
                        ['value' => 'friends', 'icon' => 'fa-heart', 'label' => 'Friends & family', 'desc' => 'I want to connect with people I care about', 'color' => 'rose'],
                        ['value' => 'brain', 'icon' => 'fa-brain', 'label' => 'Brain training', 'desc' => 'I just want to challenge myself', 'color' => 'mint'],
                    ] as $g)
                        <button type="button" @click="goal = '{{ $g['value'] }}'"
                            :class="goal === '{{ $g['value'] }}' ? 'border-indigo/50 bg-indigo/10' : 'border-border/30 bg-elevated/50 hover:border-indigo/20 hover:bg-elevated'"
                            class="w-full border rounded-xl p-4 text-left transition-all duration-200 cursor-pointer focus:outline-none flex items-center gap-4">
                            <div class="w-10 h-10 bg-{{ $g['color'] }}/10 rounded-xl flex items-center justify-center shrink-0">
                                <i class="fa-solid {{ $g['icon'] }} text-{{ $g['color'] }}-light text-sm"></i>
                            </div>
                            <div>
                                <div class="text-sm font-semibold" :class="goal === '{{ $g['value'] }}' ? 'text-indigo-light' : 'text-bright'">{{ $g['label'] }}</div>
                                <div class="text-xs text-muted">{{ $g['desc'] }}</div>
                            </div>
                        </button>
                    @endforeach
                </div>

                <div class="flex gap-3">
                    <button type="button" @click="prev()"
                        class="w-12 h-12 flex items-center justify-center border border-border/30 bg-elevated/50 text-soft rounded-full transition-all duration-200 hover:text-bright hover:border-border/50 cursor-pointer focus:outline-none shrink-0">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                    </button>
                    <button type="button" @click="next()" :disabled="!goal"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_30px_var(--color-indigo-glow)] cursor-pointer disabled:opacity-30 disabled:cursor-not-allowed disabled:hover:shadow-none disabled:hover:bg-indigo">
                        Continue
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </div>

            {{-- ===== STEP 3: Account details ===== --}}
            <div x-show="step === 3" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-cloak>
                <div class="mb-6">
                    <h2 class="font-display text-2xl font-bold text-bright mb-2">Create your account.</h2>
                    <p class="text-sm text-muted">Almost there! You'll start learning <span class="text-indigo-light font-semibold" x-text="language_name"></span> right away.</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-user text-muted text-xs"></i></div>
                            <x-text-input id="name" class="block w-full pl-10" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Your name" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-envelope text-muted text-xs"></i></div>
                            <x-text-input id="email" class="block w-full pl-10" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div x-data="{ show: false }">
                        <x-input-label for="password" :value="__('Password')" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-lock text-muted text-xs"></i></div>
                            <x-text-input id="password" class="block w-full pl-10 pr-11" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" placeholder="Min. 8 characters" />
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-muted hover:text-soft transition-colors duration-200 cursor-pointer focus:outline-none">
                                <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'" class="text-xs"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div x-data="{ show: false }">
                        <x-input-label for="password_confirmation" :value="__('Confirm password')" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fa-solid fa-shield-check text-muted text-xs"></i></div>
                            <x-text-input id="password_confirmation" class="block w-full pl-10 pr-11" x-bind:type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password" />
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-muted hover:text-soft transition-colors duration-200 cursor-pointer focus:outline-none">
                                <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'" class="text-xs"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" @click="prev()"
                        class="w-12 h-12 flex items-center justify-center border border-border/30 bg-elevated/50 text-soft rounded-full transition-all duration-200 hover:text-bright hover:border-border/50 cursor-pointer focus:outline-none shrink-0">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                    </button>
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_30px_var(--color-indigo-glow)] cursor-pointer">
                        Start learning
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>

                <p class="text-center text-[11px] text-muted mt-4">
                    By creating an account you agree to our
                    <a href="#" class="text-indigo-light hover:text-indigo transition-colors">Terms</a> and
                    <a href="#" class="text-indigo-light hover:text-indigo transition-colors">Privacy Policy</a>.
                </p>
            </div>
        </form>

        {{-- Login link (always visible) --}}
        <div class="relative mt-6">
            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-border/30"></div></div>
            <div class="relative flex justify-center"><span class="bg-night px-4 text-xs text-muted">or</span></div>
        </div>

        <p class="text-center text-sm text-muted mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="text-indigo-light hover:text-indigo font-semibold transition-colors duration-200">Log in</a>
        </p>
    </div>
</x-guest-layout>
