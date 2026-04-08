@extends('layouts.dashboard')

@section('content')
    <div class="min-h-screen bg-night" x-data="lessonApp()">

        {{-- Audio visualizer — fixed bottom of screen --}}
        <div class="fixed bottom-0 left-0 right-0 lg:left-64 flex items-end justify-center gap-[3px] h-16 px-12 pb-4 pointer-events-none z-30 opacity-0 transition-opacity duration-300" :class="isSpeaking && 'opacity-100'">
            <template x-for="(h, i) in audioBars" :key="i">
                <div class="w-1 bg-indigo-light/30 rounded-full transition-all duration-100" :style="'height:' + h + '%'"></div>
            </template>
        </div>

        <!-- Main -->
        <div class="max-w-2xl mx-auto px-6 w-full min-h-screen flex flex-col justify-center py-20 relative">

            {{-- Top bar — centered with content --}}
            <div class="absolute top-0 left-0 right-0 px-6 pt-6">
                <div class="flex items-center gap-4 mb-2">
                    <a href="{{ route('learn.language', $language->slug) }}" class="w-9 h-9 flex items-center justify-center rounded-full bg-elevated/60 text-muted hover:text-bright hover:bg-elevated transition-all duration-200 cursor-pointer shrink-0">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </a>

                    <div class="flex-1">
                        <div class="w-full bg-elevated rounded-full h-2 overflow-hidden">
                            <div class="h-2 rounded-full transition-all duration-700 ease-out bg-gradient-to-r from-indigo to-indigo-light"
                                 :style="'width:' + progressPercent + '%'"></div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ===== ACTIVE STEP ===== --}}
            <div x-show="!isComplete" x-cloak>
                <div :key="renderKey"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-x-6"
                     x-transition:enter-end="opacity-100 translate-x-0">

                    {{-- ======== FLASHCARD ======== --}}
                    <template x-if="current && current.type === 'flashcard'">
                        <div class="text-center">
                            <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full text-[10px] font-semibold text-soft uppercase tracking-widest mb-8">
                                <i class="fa-solid fa-book-open text-indigo-light text-[9px]"></i>
                                New word
                                <span class="text-muted" x-text="(flashcardsDone + 1) + '/' + totalFlashcards"></span>
                            </div>

                            {{-- Card --}}
                            <div class="relative rounded-3xl overflow-hidden max-w-md mx-auto cursor-pointer mb-8"
                                 @click="showTranslation = !showTranslation">
                                {{-- Animated background --}}
                                <div class="absolute inset-0 bg-gradient-to-br from-indigo/15 via-surface to-indigo/8 animate-[ctaGradient_8s_ease-in-out_infinite_alternate]"></div>
                                <div class="absolute inset-0 bg-gradient-to-tl from-indigo/8 via-transparent to-indigo/10 animate-[ctaGradient2_10s_ease-in-out_infinite_alternate]"></div>
                                <div class="absolute top-[10%] left-[10%] w-[200px] h-[200px] bg-indigo/10 rounded-full blur-[80px] animate-[blob1_18s_ease-in-out_infinite]"></div>

                                <div class="relative px-10 py-12">
                                    <div class="text-[10px] text-soft/60 uppercase tracking-widest mb-4" x-text="current.lang"></div>
                                    <div class="font-display text-4xl sm:text-5xl font-bold text-bright italic mb-5" x-text="current.word"></div>
                                    <div class="gold-line mx-auto my-5"></div>

                                    <div x-show="!showTranslation" class="text-soft text-sm">Tap to reveal translation</div>
                                    <div x-show="showTranslation" x-transition class="font-display text-2xl font-bold text-gradient italic" x-text="current.translation"></div>
                                </div>

                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center justify-center gap-4">
                                <button @click="speak(current.word, current.lang)"
                                    class="w-12 h-12 rounded-full bg-elevated/60 hover:bg-indigo/15 flex items-center justify-center text-muted hover:text-indigo-light transition-all duration-200 cursor-pointer">
                                    <i class="fa-solid fa-volume-high text-sm"></i>
                                </button>
                                <button @click="advanceStep()" class="group inline-flex items-center gap-2 px-8 py-3.5 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_30px_var(--color-indigo-glow)] cursor-pointer">
                                    Got it
                                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                                </button>
                            </div>
                        </div>
                    </template>

                    {{-- ======== MULTIPLE CHOICE ======== --}}
                    <template x-if="current && current.type === 'multiple_choice'">
                        <div>
                            <div class="text-center mb-10">
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-mint/10 border border-mint/20 rounded-full text-[11px] font-semibold text-mint uppercase tracking-wider mb-6">
                                    <i class="fa-solid fa-gamepad text-[10px]"></i>
                                    Choose the answer
                                </div>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-bright" x-text="current.question"></h2>
                            </div>

                            <div class="space-y-3 max-w-md mx-auto">
                                <template x-for="(option, oi) in current.options" :key="oi">
                                    <button @click="pickChoice(option)"
                                        :disabled="choiceState !== null"
                                        :class="{
                                            'border-border bg-surface hover:border-indigo/30 hover:bg-elevated cursor-pointer': choiceState === null,
                                            'border-mint/40 bg-mint/10 shadow-[0_0_15px_var(--color-mint-glow)]': choiceState !== null && option === current.correct,
                                            'border-danger/40 bg-danger/10': choiceState === 'wrong' && option === choicePicked,
                                            'border-border bg-surface opacity-30': choiceState !== null && option !== current.correct && option !== choicePicked,
                                            'cursor-not-allowed': choiceState !== null,
                                        }"
                                        class="w-full px-6 py-4 border rounded-2xl text-left font-medium transition-all duration-300">
                                        <div class="flex items-center justify-between">
                                            <span class="text-bright" x-text="option"></span>
                                            <template x-if="choiceState !== null && option === current.correct">
                                                <i class="fa-solid fa-circle-check text-mint"></i>
                                            </template>
                                            <template x-if="choiceState === 'wrong' && option === choicePicked">
                                                <i class="fa-solid fa-circle-xmark text-danger"></i>
                                            </template>
                                        </div>
                                    </button>
                                </template>
                            </div>

                            <div x-show="choiceState !== null" x-transition class="mt-8 text-center">
                                <div x-show="choiceState === 'correct'"
                                     class="inline-flex items-center gap-2 px-5 py-3 bg-mint/10 border border-mint/20 rounded-2xl text-sm font-medium text-mint mb-5">
                                    <i class="fa-solid fa-check"></i> Nice work!
                                </div>
                                <div x-show="choiceState === 'wrong'"
                                     class="inline-flex items-center gap-2 px-5 py-3 bg-danger/10 border border-danger/20 rounded-2xl text-sm font-medium text-danger mb-5">
                                    <i class="fa-solid fa-rotate-left text-xs"></i>
                                    We'll ask this one again later
                                </div>
                                <div>
                                    <button @click="advanceStep()" class="group inline-flex items-center gap-2 px-8 py-3 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_20px_var(--color-indigo-glow)]">
                                        Continue <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- ======== TYPING ======== --}}
                    <template x-if="current && current.type === 'typing'">
                        <div>
                            <div class="text-center mb-10">
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-sun/10 border border-sun/20 rounded-full text-[11px] font-semibold text-sun uppercase tracking-wider mb-6">
                                    <i class="fa-solid fa-keyboard text-[10px]"></i>
                                    Type your answer
                                </div>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-bright" x-text="current.question"></h2>
                                <div class="mt-3 text-sm text-muted">
                                    Hint: <span class="font-mono text-soft tracking-widest" x-text="current.hint"></span>
                                </div>

                                <button @click="speak(current.correct, current.lang || '{{ $language->name }}')"
                                        class="mt-2 inline-flex items-center gap-1.5 text-xs text-muted hover:text-indigo-light transition-colors">
                                    <i class="fa-solid fa-volume-high text-[10px]"></i> Listen
                                </button>
                            </div>

                            <div class="max-w-md mx-auto">
                                <div class="relative">
                                    <input type="text"
                                        x-ref="typingField"
                                        x-model="typingValue"
                                        @keydown.enter="checkType()"
                                        :disabled="typeState !== null"
                                        :class="{
                                            'border-border focus:border-indigo/50 focus:ring-indigo/30': typeState === null,
                                            'border-mint/40 bg-mint/5': typeState === 'correct',
                                            'border-danger/40 bg-danger/5': typeState === 'wrong',
                                        }"
                                        class="w-full px-6 py-4 bg-elevated border rounded-2xl text-bright text-center text-xl font-medium placeholder-muted focus:outline-none focus:ring-2 transition-all duration-200"
                                        placeholder="Type here..." autocomplete="off" autocapitalize="off" spellcheck="false">
                                    <template x-if="typeState === 'correct'">
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2"><i class="fa-solid fa-circle-check text-mint text-xl"></i></div>
                                    </template>
                                    <template x-if="typeState === 'wrong'">
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2"><i class="fa-solid fa-circle-xmark text-danger text-xl"></i></div>
                                    </template>
                                </div>

                                <div x-show="typeState === null" class="mt-6 text-center">
                                    <button @click="checkType()" class="group inline-flex items-center gap-2 px-8 py-3 bg-sun hover:bg-sun-light text-night text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_20px_var(--color-sun-glow)]">
                                        <i class="fa-solid fa-check text-xs"></i> Check
                                    </button>
                                </div>

                                <div x-show="typeState !== null" x-transition class="mt-6 text-center">
                                    <div x-show="typeState === 'correct'"
                                         class="inline-flex items-center gap-2 px-5 py-3 bg-mint/10 border border-mint/20 rounded-2xl text-sm font-medium text-mint mb-5">
                                        <i class="fa-solid fa-check"></i> Perfect!
                                    </div>
                                    <div x-show="typeState === 'wrong'"
                                         class="space-y-2 mb-5">
                                        <div class="inline-flex items-center gap-2 px-5 py-3 bg-danger/10 border border-danger/20 rounded-2xl text-sm font-medium text-danger">
                                            <i class="fa-solid fa-lightbulb"></i>
                                            Correct: <strong class="font-mono" x-text="current.correct"></strong>
                                        </div>
                                        <div class="text-xs text-muted"><i class="fa-solid fa-rotate-left text-[10px] mr-1"></i>We'll ask this one again</div>
                                    </div>
                                    <div>
                                        <button @click="advanceStep()" class="group inline-flex items-center gap-2 px-8 py-3 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_20px_var(--color-indigo-glow)]">
                                            Continue <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    {{-- ======== MATCHING ======== --}}
                    <template x-if="current && current.type === 'matching'">
                        <div>
                            <div class="text-center mb-8">
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-sky/10 border border-sky/20 rounded-full text-[11px] font-semibold text-sky-light uppercase tracking-wider mb-6">
                                    <i class="fa-solid fa-link text-[10px]"></i>
                                    Match the pairs
                                </div>
                                <h2 class="text-xl sm:text-2xl font-extrabold text-bright" x-text="current.instruction"></h2>
                            </div>

                            <div class="max-w-lg mx-auto">
                                <div class="grid grid-cols-2 gap-4">
                                    {{-- Left column: words --}}
                                    <div class="space-y-2">
                                        <template x-for="(pair, pi) in current.pairs" :key="'w'+pi">
                                            <button @click="matchSelect('word', pi)"
                                                :class="{
                                                    'border-indigo/40 bg-indigo/10': matchSelected.word === pi && !matchDone.includes(pi),
                                                    'border-mint/40 bg-mint/10 opacity-50': matchDone.includes(pi),
                                                    'border-border bg-surface hover:border-indigo/20 cursor-pointer': matchSelected.word !== pi && !matchDone.includes(pi),
                                                }"
                                                :disabled="matchDone.includes(pi)"
                                                class="w-full px-4 py-3.5 border rounded-xl text-sm font-semibold text-bright transition-all duration-200 focus:outline-none">
                                                <span x-text="pair.word"></span>
                                                <template x-if="matchDone.includes(pi)">
                                                    <i class="fa-solid fa-check text-mint-light text-xs ml-2"></i>
                                                </template>
                                            </button>
                                        </template>
                                    </div>
                                    {{-- Right column: translations (shuffled) --}}
                                    <div class="space-y-2">
                                        <template x-for="(ti, si) in matchShuffled" :key="'t'+si">
                                            <button @click="matchSelect('translation', ti)"
                                                :class="{
                                                    'border-indigo/40 bg-indigo/10': matchSelected.translation === ti && !matchDone.includes(ti),
                                                    'border-mint/40 bg-mint/10 opacity-50': matchDone.includes(ti),
                                                    'border-danger/40 bg-danger/10': matchWrong === ti,
                                                    'border-border bg-surface hover:border-indigo/20 cursor-pointer': matchSelected.translation !== ti && !matchDone.includes(ti) && matchWrong !== ti,
                                                }"
                                                :disabled="matchDone.includes(ti)"
                                                class="w-full px-4 py-3.5 border rounded-xl text-sm font-medium text-soft transition-all duration-200 focus:outline-none">
                                                <span x-text="current.pairs[ti].translation"></span>
                                                <template x-if="matchDone.includes(ti)">
                                                    <i class="fa-solid fa-check text-mint-light text-xs ml-2"></i>
                                                </template>
                                            </button>
                                        </template>
                                    </div>
                                </div>

                                <div class="text-center mt-4 text-xs text-muted">
                                    <span x-text="matchDone.length"></span>/<span x-text="current.pairs.length"></span> matched
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- ======== LISTENING ======== --}}
                    <template x-if="current && current.type === 'listening'">
                        <div>
                            <div class="text-center mb-10">
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-rose/10 border border-rose/20 rounded-full text-[11px] font-semibold text-rose-light uppercase tracking-wider mb-6">
                                    <i class="fa-solid fa-headphones text-[10px]"></i>
                                    Listening
                                </div>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-bright mb-6" x-text="current.question"></h2>

                                <button @click="speak(current.word, current.lang)"
                                    class="w-20 h-20 rounded-2xl bg-indigo/15 hover:bg-indigo/25 flex items-center justify-center mx-auto transition-all duration-200 cursor-pointer group">
                                    <i class="fa-solid fa-volume-high text-indigo-light text-2xl group-hover:scale-110 transition-transform duration-200"></i>
                                </button>
                                <button @click="speak(current.word, current.lang)"
                                    class="mt-3 text-xs text-muted hover:text-indigo-light transition-colors cursor-pointer">
                                    <i class="fa-solid fa-rotate-right text-[10px] mr-1"></i> Play again
                                </button>
                            </div>

                            <div class="space-y-3 max-w-md mx-auto">
                                <template x-for="(option, oi) in current.options" :key="oi">
                                    <button @click="pickChoice(option)"
                                        :disabled="choiceState !== null"
                                        :class="{
                                            'border-border bg-surface hover:border-indigo/30 hover:bg-elevated cursor-pointer': choiceState === null,
                                            'border-mint/40 bg-mint/10 shadow-[0_0_15px_var(--color-mint-glow)]': choiceState !== null && option === current.correct,
                                            'border-danger/40 bg-danger/10': choiceState === 'wrong' && option === choicePicked,
                                            'border-border bg-surface opacity-30': choiceState !== null && option !== current.correct && option !== choicePicked,
                                            'cursor-not-allowed': choiceState !== null,
                                        }"
                                        class="w-full px-6 py-4 border rounded-2xl text-left font-medium transition-all duration-300">
                                        <div class="flex items-center justify-between">
                                            <span class="text-bright" x-text="option"></span>
                                            <template x-if="choiceState !== null && option === current.correct">
                                                <i class="fa-solid fa-circle-check text-mint"></i>
                                            </template>
                                            <template x-if="choiceState === 'wrong' && option === choicePicked">
                                                <i class="fa-solid fa-circle-xmark text-danger"></i>
                                            </template>
                                        </div>
                                    </button>
                                </template>
                            </div>

                            <div x-show="choiceState !== null" x-transition class="mt-8 text-center">
                                <div x-show="choiceState === 'correct'" class="inline-flex items-center gap-2 px-5 py-3 bg-mint/10 border border-mint/20 rounded-2xl text-sm font-medium text-mint mb-5">
                                    <i class="fa-solid fa-check"></i> Correct!
                                </div>
                                <div x-show="choiceState === 'wrong'" class="inline-flex items-center gap-2 px-5 py-3 bg-danger/10 border border-danger/20 rounded-2xl text-sm font-medium text-danger mb-5">
                                    <i class="fa-solid fa-rotate-left text-xs"></i> The word was "<span class="font-bold" x-text="current.word"></span>"
                                </div>
                                <div>
                                    <button @click="advanceStep()" class="group inline-flex items-center gap-2 px-8 py-3 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_20px_var(--color-indigo-glow)]">
                                        Continue <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- ======== TRUE/FALSE ======== --}}
                    <template x-if="current && current.type === 'true_false'">
                        <div>
                            <div class="text-center mb-10">
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-sun/10 border border-sun/20 rounded-full text-[11px] font-semibold text-sun-light uppercase tracking-wider mb-6">
                                    <i class="fa-solid fa-scale-balanced text-[10px]"></i>
                                    True or false
                                </div>
                                <h2 class="text-xl sm:text-2xl font-extrabold text-bright mb-2">Is this correct?</h2>
                                <p class="text-lg text-soft mt-4" x-text="current.question"></p>
                            </div>

                            <div class="flex gap-4 max-w-md mx-auto">
                                <button @click="pickTrueFalse('true')"
                                    :disabled="tfState !== null"
                                    :class="{
                                        'border-border bg-surface hover:border-mint/30 hover:bg-mint/5 cursor-pointer': tfState === null,
                                        'border-mint/40 bg-mint/10 shadow-[0_0_15px_var(--color-mint-glow)]': tfState !== null && current.correct === 'true',
                                        'border-danger/40 bg-danger/10': tfState === 'wrong' && tfPicked === 'true',
                                        'border-border bg-surface opacity-30': tfState !== null && current.correct !== 'true' && tfPicked !== 'true',
                                        'cursor-not-allowed': tfState !== null,
                                    }"
                                    class="flex-1 py-6 border rounded-2xl text-center font-bold text-lg transition-all duration-300">
                                    <i class="fa-solid fa-check text-mint-light mr-2"></i>
                                    <span class="text-bright">True</span>
                                </button>
                                <button @click="pickTrueFalse('false')"
                                    :disabled="tfState !== null"
                                    :class="{
                                        'border-border bg-surface hover:border-danger/30 hover:bg-danger/5 cursor-pointer': tfState === null,
                                        'border-mint/40 bg-mint/10 shadow-[0_0_15px_var(--color-mint-glow)]': tfState !== null && current.correct === 'false',
                                        'border-danger/40 bg-danger/10': tfState === 'wrong' && tfPicked === 'false',
                                        'border-border bg-surface opacity-30': tfState !== null && current.correct !== 'false' && tfPicked !== 'false',
                                        'cursor-not-allowed': tfState !== null,
                                    }"
                                    class="flex-1 py-6 border rounded-2xl text-center font-bold text-lg transition-all duration-300">
                                    <i class="fa-solid fa-xmark text-danger mr-2"></i>
                                    <span class="text-bright">False</span>
                                </button>
                            </div>

                            <div x-show="tfState !== null" x-transition class="mt-8 text-center">
                                <div x-show="tfState === 'correct'" class="inline-flex items-center gap-2 px-5 py-3 bg-mint/10 border border-mint/20 rounded-2xl text-sm font-medium text-mint mb-5">
                                    <i class="fa-solid fa-check"></i> Correct!
                                </div>
                                <div x-show="tfState === 'wrong'" class="space-y-2 mb-5">
                                    <div class="inline-flex items-center gap-2 px-5 py-3 bg-danger/10 border border-danger/20 rounded-2xl text-sm font-medium text-danger">
                                        <i class="fa-solid fa-lightbulb"></i>
                                        The correct translation is "<span class="font-bold" x-text="current.actual_translation"></span>"
                                    </div>
                                </div>
                                <div>
                                    <button @click="advanceStep()" class="group inline-flex items-center gap-2 px-8 py-3 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_20px_var(--color-indigo-glow)]">
                                        Continue <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                </div>
            </div>

            {{-- ===== COMPLETION ===== --}}
            <div x-show="isComplete" x-cloak
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="text-center py-8">

                <div class="w-20 h-20 bg-mint/10 rounded-3xl flex items-center justify-center mx-auto mb-6 pulse-ring">
                    <i class="fa-solid fa-trophy text-mint text-3xl"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-bright mb-2">Lesson complete!</h2>
                <p class="text-muted mb-4">{{ $lesson->title }}</p>

                <div class="flex justify-center gap-1 mb-10">
                    <template x-for="i in 5" :key="i">
                        <i class="fa-solid fa-star text-xl" :class="i <= Math.ceil(result.score / 20) ? 'text-sun' : 'text-elevated'"></i>
                    </template>
                </div>

                <div class="grid grid-cols-3 gap-3 max-w-sm mx-auto mb-10">
                    <div class="glass-card rounded-2xl p-5 text-center">
                        <i class="fa-solid fa-bolt text-indigo-light text-lg mb-2"></i>
                        <div class="text-xl font-extrabold text-gradient">+<span x-text="result.xp_earned"></span></div>
                        <div class="text-[10px] text-muted mt-1 uppercase tracking-wider">XP</div>
                    </div>
                    <div class="glass-card rounded-2xl p-5 text-center">
                        <i class="fa-solid fa-bullseye text-bright text-lg mb-2"></i>
                        <div class="text-xl font-extrabold text-bright"><span x-text="result.score"></span>%</div>
                        <div class="text-[10px] text-muted mt-1 uppercase tracking-wider">Score</div>
                    </div>
                    <div class="glass-card rounded-2xl p-5 text-center">
                        <i class="fa-solid fa-fire-flame-curved text-sun text-lg mb-2"></i>
                        <div class="text-xl font-extrabold text-sun"><span x-text="result.current_streak"></span></div>
                        <div class="text-[10px] text-muted mt-1 uppercase tracking-wider">Streak</div>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-6 max-w-sm mx-auto mb-10 text-left">
                    <div class="text-xs text-muted uppercase tracking-wider mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-book text-indigo-light text-[10px]"></i> Words learned
                    </div>
                    <div class="space-y-2">
                        @foreach($steps as $step)
                            @if($step['type'] === 'flashcard')
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-bright font-medium">{{ $step['word'] }}</span>
                                    <span class="text-muted">{{ $step['translation'] }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a x-show="result.next_lesson_url" :href="result.next_lesson_url"
                       class="group inline-flex items-center justify-center gap-2 px-8 py-3 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_20px_var(--color-indigo-glow)]">
                        Next lesson <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
                    </a>
                    <a :href="result.language_url"
                       class="inline-flex items-center justify-center gap-2 px-8 py-3 glass hover:bg-elevated text-text text-sm font-semibold rounded-full transition-all duration-200">
                        <i class="fa-solid fa-road text-xs text-muted"></i> Back to path
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
    function lessonApp() {
        return {
            // Raw steps from server
            allSteps: @json($steps),

            // Queue engine
            queue: [],           // steps still to do
            current: null,       // the step being shown right now
            completed: new Set(), // step IDs that were answered correctly
            retryQueue: [],      // wrong answers get re-queued here

            // UI state per step
            showTranslation: false,
            choiceState: null,   // null | 'correct' | 'wrong'
            choicePicked: null,
            typeState: null,     // null | 'correct' | 'wrong'
            typingValue: '',
            tfState: null,       // null | 'correct' | 'wrong'
            tfPicked: null,
            matchSelected: { word: null, translation: null },
            matchDone: [],
            matchShuffled: [],
            matchWrong: null,
            isSpeaking: false,
            audioBars: Array(28).fill(5),
            audioInterval: null,
            renderKey: 0,

            // Scoring
            totalAttempts: 0,
            correctFirst: 0,     // correct on first try (for score)
            totalGradeable: 0,   // how many gradeable steps in original set

            // Progress
            stepsFinished: 0,
            totalSteps: 0,
            flashcardsDone: 0,
            totalFlashcards: 0,

            // Lives
            lives: 3,
            maxLives: 3,

            isComplete: false,
            result: {},

            get phase() {
                if (!this.current) return 'learn';
                if (this.current.type === 'flashcard') return 'learn';
                if (this.current.type === 'matching') return 'match';
                if (this.current.type === 'listening') return 'listen';
                return 'practice';
            },

            get progressPercent() {
                if (this.totalSteps === 0) return 0;
                return Math.min(100, Math.round((this.stepsFinished / this.totalSteps) * 100));
            },

            init() {
                // Tag each step with a unique ID
                this.allSteps.forEach((s, i) => s._id = i);

                this.totalFlashcards = this.allSteps.filter(s => s.type === 'flashcard').length;
                this.totalGradeable = this.allSteps.filter(s => s.type !== 'flashcard').reduce((sum, s) => {
                    return sum + (s.type === 'matching' ? s.pairs.length : 1);
                }, 0);
                this.totalSteps = this.allSteps.length;

                // Load the queue
                this.queue = [...this.allSteps];
                this.showNext();
            },

            showNext() {
                // Reset per-step UI
                this.showTranslation = false;
                this.choiceState = null;
                this.choicePicked = null;
                this.typeState = null;
                this.typingValue = '';
                this.tfState = null;
                this.tfPicked = null;
                this.matchSelected = { word: null, translation: null };
                this.matchDone = [];
                this.matchWrong = null;
                this.renderKey++;

                if (this.queue.length === 0) {
                    // Check if there are retry items
                    if (this.retryQueue.length > 0) {
                        // Shuffle retry queue and add back
                        this.queue = [...this.retryQueue].sort(() => Math.random() - 0.5);
                        this.retryQueue = [];
                        this.totalSteps += this.queue.length; // extend total for progress
                    } else {
                        this.finishLesson();
                        return;
                    }
                }

                this.current = this.queue.shift();

                this.$nextTick(() => {
                    // Auto-speak flashcard
                    if (this.current.type === 'flashcard') {
                        setTimeout(() => this.speak(this.current.word, this.current.lang), 300);
                    }
                    // Auto-focus typing
                    if (this.current.type === 'typing') {
                        setTimeout(() => { if (this.$refs.typingField) this.$refs.typingField.focus(); }, 400);
                    }
                    // Auto-play listening
                    if (this.current.type === 'listening') {
                        setTimeout(() => this.speak(this.current.word, this.current.lang), 400);
                    }
                    // Shuffle matching translations
                    if (this.current.type === 'matching') {
                        this.matchShuffled = [...Array(this.current.pairs.length).keys()].sort(() => Math.random() - 0.5);
                    }
                });
            },

            advanceStep() {
                this.stepsFinished++;
                if (this.current.type === 'flashcard') this.flashcardsDone++;
                this.showNext();
            },

            // === Multiple choice ===
            pickChoice(option) {
                if (this.choiceState !== null) return;
                this.choicePicked = option;
                this.totalAttempts++;

                if (option === this.current.correct) {
                    this.choiceState = 'correct';
                    if (!this.completed.has(this.current._id)) {
                        this.correctFirst++;
                    }
                    this.completed.add(this.current._id);
                } else {
                    this.choiceState = 'wrong';
                    this.lives = Math.max(0, this.lives - 1);
                    // Re-queue: create a new variant of this question
                    this.requeueWrong(this.current);
                }
            },

            // === Typing ===
            normalize(str) {
                return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().trim();
            },

            checkType() {
                if (this.typeState !== null) return;
                const input = this.typingValue.trim().toLowerCase();
                if (!input) return;
                const correct = this.current.correct.toLowerCase();
                this.totalAttempts++;

                if (input === correct || this.normalize(input) === this.normalize(correct)) {
                    this.typeState = 'correct';
                    if (!this.completed.has(this.current._id)) {
                        this.correctFirst++;
                    }
                    this.completed.add(this.current._id);
                } else {
                    this.typeState = 'wrong';
                    this.lives = Math.max(0, this.lives - 1);
                    this.requeueWrong(this.current);
                }
            },

            // === True/False ===
            pickTrueFalse(answer) {
                if (this.tfState !== null) return;
                this.tfPicked = answer;
                this.totalAttempts++;

                if (answer === this.current.correct) {
                    this.tfState = 'correct';
                    if (!this.completed.has(this.current._id)) {
                        this.correctFirst++;
                    }
                    this.completed.add(this.current._id);
                } else {
                    this.tfState = 'wrong';
                    this.lives = Math.max(0, this.lives - 1);
                    this.requeueWrong(this.current);
                }
            },

            // === Matching ===
            matchSelect(side, index) {
                if (this.matchDone.includes(index) && side === 'word') return;
                if (this.matchDone.includes(index) && side === 'translation') return;

                this.matchWrong = null;
                this.matchSelected[side] = index;

                // Check if both sides selected
                if (this.matchSelected.word !== null && this.matchSelected.translation !== null) {
                    this.totalAttempts++;
                    if (this.matchSelected.word === this.matchSelected.translation) {
                        // Correct match
                        this.matchDone.push(this.matchSelected.word);
                        if (!this.completed.has(this.current._id + '_' + this.matchSelected.word)) {
                            this.correctFirst++;
                        }
                        this.completed.add(this.current._id + '_' + this.matchSelected.word);

                        // Check if all matched
                        if (this.matchDone.length === this.current.pairs.length) {
                            setTimeout(() => this.advanceStep(), 600);
                        }
                    } else {
                        // Wrong match
                        this.matchWrong = this.matchSelected.translation;
                        this.lives = Math.max(0, this.lives - 1);
                        setTimeout(() => { this.matchWrong = null; }, 800);
                    }
                    this.matchSelected = { word: null, translation: null };
                }
            },

            // Re-queue a wrong answer so it comes back later in a different form
            requeueWrong(step) {
                const wordPairs = this.allSteps.filter(s => s.type === 'flashcard');

                if (step.type === 'typing') {
                    // Find the matching flashcard to get the translation context
                    const flash = wordPairs.find(w => w.word.toLowerCase() === step.correct.toLowerCase());
                    const translation = flash ? flash.translation : step.question.replace(/.*"(.+)".*/, '$1');

                    // Retry as multiple choice: "How do you say X?"
                    const wrongWords = wordPairs
                        .filter(w => w.word.toLowerCase() !== step.correct.toLowerCase())
                        .sort(() => Math.random() - 0.5)
                        .slice(0, 2)
                        .map(w => w.word);

                    if (wrongWords.length >= 2) {
                        this.retryQueue.push({
                            _id: step._id, _retry: true,
                            type: 'multiple_choice',
                            question: `How do you say "${translation}"?`,
                            correct: step.correct,
                            options: [step.correct, ...wrongWords].sort(() => Math.random() - 0.5),
                        });
                    } else {
                        // Not enough distractors, just re-ask as typing
                        this.retryQueue.push({ ...step, _retry: true });
                    }
                } else if (step.type === 'multiple_choice' || step.type === 'listening') {
                    // Retry with reshuffled options
                    this.retryQueue.push({
                        ...step,
                        _retry: true,
                        options: [...step.options].sort(() => Math.random() - 0.5),
                    });
                } else if (step.type === 'true_false') {
                    // Retry as multiple choice instead
                    const wordPairs = this.allSteps.filter(s => s.type === 'flashcard');
                    const flash = wordPairs.find(w => w.word === step.question.split('"')[1]);
                    if (flash) {
                        const wrong = wordPairs.filter(w => w.word !== flash.word).sort(() => Math.random() - 0.5).slice(0, 3).map(w => w.translation);
                        this.retryQueue.push({
                            _id: step._id, _retry: true,
                            type: 'multiple_choice',
                            question: `What does "${flash.word}" mean?`,
                            correct: flash.translation,
                            options: [flash.translation, ...wrong].sort(() => Math.random() - 0.5),
                        });
                    } else {
                        this.retryQueue.push({ ...step, _retry: true });
                    }
                } else {
                    this.retryQueue.push({ ...step, _retry: true });
                }
            },

            _speakId: 0,

            speak(word, lang) {
                const langCodes = {
                    'Dutch': ['nl-NL','nl'], 'German': ['de-DE','de'], 'French': ['fr-FR','fr'],
                    'Spanish': ['es-ES','es-MX','es'], 'Portuguese': ['pt-PT','pt-BR','pt'],
                    'Italian': ['it-IT','it'], 'Turkish': ['tr-TR','tr'], 'Russian': ['ru-RU','ru'],
                    'Arabic': ['ar-SA','ar-AE','ar-EG','ar'], 'Japanese': ['ja-JP','ja'], 'Chinese': ['zh-CN','zh-TW','zh'],
                };
                const codes = langCodes[lang] || ['en-US'];
                const voices = speechSynthesis.getVoices();
                let voice = null;
                for (const code of codes) {
                    voice = voices.find(v => v.lang.startsWith(code.split('-')[0]));
                    if (voice) break;
                }

                // Stop previous without killing visualizer
                this._speakId++;
                const myId = this._speakId;
                speechSynthesis.cancel();

                const u = new SpeechSynthesisUtterance(word);
                u.lang = codes[0];
                if (voice) u.voice = voice;
                u.rate = 0.8;

                // Start visualizer
                this.isSpeaking = true;
                if (this.audioInterval) clearInterval(this.audioInterval);
                this.audioInterval = setInterval(() => {
                    this.audioBars = this.audioBars.map((_, i) => {
                        const center = this.audioBars.length / 2;
                        const dist = Math.abs(i - center) / center;
                        const base = Math.max(8, 70 * (1 - dist * 0.6));
                        return Math.min(100, Math.max(5, base + (Math.random() - 0.5) * 60));
                    });
                }, 80);

                const stopBars = () => {
                    if (myId !== this._speakId) return; // newer speak call took over
                    this.isSpeaking = false;
                    if (this.audioInterval) clearInterval(this.audioInterval);
                    this.audioBars = this.audioBars.map(() => 5);
                };
                u.onend = stopBars;
                u.onerror = stopBars;

                speechSynthesis.speak(u);
            },

            async finishLesson() {
                const score = this.totalGradeable > 0
                    ? Math.round((this.correctFirst / this.totalGradeable) * 100)
                    : 100;

                try {
                    const r = await fetch('{{ route("learn.complete", $lesson) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ score }),
                    });
                    this.result = await r.json();
                } catch (e) {
                    this.result = { xp_earned: 0, score, current_streak: 0, next_lesson_url: null, language_url: '{{ route("learn.language", $language->slug) }}' };
                }
                this.isComplete = true;
            },
        }
    }
    </script>
@endsection
