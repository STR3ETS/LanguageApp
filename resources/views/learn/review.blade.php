@extends('layouts.dashboard')

@section('content')
    <div class="py-8 lg:py-10">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">

            {{-- Back link --}}
            <a href="{{ route('learn.language', $language->slug) }}" class="inline-flex items-center gap-2 text-sm text-muted hover:text-indigo-light transition-colors mb-8 cursor-pointer">
                <i class="fa-solid fa-arrow-left text-xs"></i> Back to {{ $language->name }}
            </a>

            {{-- Header --}}
            <div class="glass-card rounded-2xl p-6 mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-mint/15 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-circle-check text-mint-light text-lg"></i>
                        </div>
                        <div>
                            <h1 class="font-display text-xl font-bold text-bright">{{ $lesson->title }}</h1>
                            <div class="flex items-center gap-3 mt-1 text-xs text-muted">
                                <span><i class="fa-solid fa-{{ $lesson->type === 'vocabulary' ? 'book' : ($lesson->type === 'grammar' ? 'pen-ruler' : 'comments') }} text-[10px] mr-1"></i>{{ ucfirst($lesson->type) }}</span>
                                <span>·</span>
                                <span>{{ $lesson->level->language->name }}</span>
                                <span>·</span>
                                <span>{{ $lesson->level->name }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Score --}}
                    <div class="flex items-center gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-display font-bold text-bright">{{ $progress->score }}%</div>
                            <div class="text-[10px] text-muted uppercase tracking-widest">Score</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-display font-bold text-indigo-light">+{{ $progress->xp_earned }}</div>
                            <div class="text-[10px] text-muted uppercase tracking-widest">XP earned</div>
                        </div>
                        <div class="text-center">
                            <div class="flex gap-0.5">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="fa-solid fa-star text-sm {{ $i < round($progress->score / 20) ? 'text-sun-light' : 'text-elevated' }}"></i>
                                @endfor
                            </div>
                            <div class="text-[10px] text-muted uppercase tracking-widest mt-1">Rating</div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-4 pt-4 border-t border-border/20 text-xs text-muted">
                    <i class="fa-solid fa-clock text-[10px]"></i>
                    Completed {{ $progress->completed_at->diffForHumans() }}
                </div>
            </div>

            {{-- Word pairs --}}
            <div class="mb-8">
                <h2 class="text-sm font-semibold text-muted uppercase tracking-widest flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-book-open text-indigo-light text-xs"></i>
                    Words in this level
                </h2>

                <div class="space-y-2">
                    @foreach($wordPairs as $i => $pair)
                        <div class="glass-card rounded-xl p-4 flex items-center gap-4 group hover:border-indigo/15 transition-all duration-300">
                            <div class="w-8 h-8 rounded-lg bg-indigo/10 flex items-center justify-center shrink-0">
                                <span class="text-[11px] font-bold text-indigo-light">{{ $i + 1 }}</span>
                            </div>
                            <div class="flex-1 flex items-center gap-3 min-w-0">
                                <span class="font-display font-bold text-bright text-sm italic">{{ $pair['word'] }}</span>
                                <i class="fa-solid fa-arrow-right text-[8px] text-muted"></i>
                                <span class="text-sm text-soft">{{ $pair['translation'] }}</span>
                            </div>
                            <button onclick="window._reviewSpeak('{{ addslashes($pair['word']) }}')" class="w-8 h-8 rounded-lg bg-elevated hover:bg-indigo/10 flex items-center justify-center text-muted hover:text-indigo-light transition-all duration-200 cursor-pointer shrink-0" title="Listen">
                                <i class="fa-solid fa-volume-high text-xs"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Flashcard mode --}}
            <div class="mb-8">
                <h2 class="text-sm font-semibold text-muted uppercase tracking-widest flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-layer-group text-mint-light text-xs"></i>
                    Quick review
                </h2>

                <div class="glass-card rounded-2xl p-8" x-data="{ current: 0, flipped: false, words: {{ Js::from($wordPairs) }} }">
                    <div class="text-center">
                        <div class="text-[10px] text-muted uppercase tracking-widest mb-4">
                            <span x-text="current + 1"></span> / <span x-text="words.length"></span>
                        </div>

                        {{-- Card --}}
                        <div @click="flipped = !flipped" class="cursor-pointer select-none mb-6 py-10 rounded-xl bg-elevated/50 border border-border/20 hover:border-indigo/15 transition-all duration-300">
                            <div x-show="!flipped">
                                <div class="font-display text-3xl font-bold text-bright italic mb-2" x-text="words[current].word"></div>
                                <div class="text-xs text-muted">Tap to reveal translation</div>
                            </div>
                            <div x-show="flipped" x-cloak>
                                <div class="font-display text-3xl font-bold text-indigo-light mb-2" x-text="words[current].translation"></div>
                                <div class="text-sm text-soft italic" x-text="words[current].word"></div>
                            </div>
                        </div>

                        {{-- Navigation --}}
                        <div class="flex items-center justify-center gap-3">
                            <button @click="current = Math.max(0, current - 1); flipped = false" :disabled="current === 0"
                                class="w-10 h-10 rounded-full bg-elevated hover:bg-elevated/80 flex items-center justify-center text-muted hover:text-bright transition-all cursor-pointer disabled:opacity-30 disabled:cursor-not-allowed focus:outline-none">
                                <i class="fa-solid fa-arrow-left text-xs"></i>
                            </button>
                            <button @click="flipped = !flipped"
                                class="px-5 py-2.5 rounded-full bg-indigo/10 text-indigo-light text-xs font-semibold hover:bg-indigo/15 transition-all cursor-pointer focus:outline-none">
                                <i class="fa-solid fa-rotate text-[10px] mr-1"></i> Flip
                            </button>
                            <button @click="current = Math.min(words.length - 1, current + 1); flipped = false" :disabled="current === words.length - 1"
                                class="w-10 h-10 rounded-full bg-elevated hover:bg-elevated/80 flex items-center justify-center text-muted hover:text-bright transition-all cursor-pointer disabled:opacity-30 disabled:cursor-not-allowed focus:outline-none">
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('learn.lesson', $lesson) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-indigo hover:bg-indigo-light text-white font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_30px_var(--color-indigo-glow)] cursor-pointer">
                    <i class="fa-solid fa-rotate text-xs"></i> Practice again
                </a>
                <a href="{{ route('learn.language', $language->slug) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3.5 glass hover:bg-elevated text-text font-semibold rounded-full transition-all duration-300 cursor-pointer">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Back to path
                </a>
            </div>

        </div>
    </div>

    <script>
    window._reviewSpeak = function(word) {
        if (!('speechSynthesis' in window)) return;

        const langName = '{{ $language->name }}';
        const langCodes = {
            'Dutch': ['nl-NL', 'nl'],
            'German': ['de-DE', 'de'],
            'French': ['fr-FR', 'fr'],
            'Spanish': ['es-ES', 'es-MX', 'es'],
            'Portuguese': ['pt-PT', 'pt-BR', 'pt'],
            'Italian': ['it-IT', 'it'],
            'Turkish': ['tr-TR', 'tr'],
            'Russian': ['ru-RU', 'ru'],
            'Arabic': ['ar-SA', 'ar-AE', 'ar-EG', 'ar'],
            'Japanese': ['ja-JP', 'ja'],
            'Chinese': ['zh-CN', 'zh-TW', 'zh'],
        };

        const codes = langCodes[langName] || ['en-US'];
        const voices = speechSynthesis.getVoices();

        // Find best matching voice
        let voice = null;
        for (const code of codes) {
            voice = voices.find(v => v.lang.startsWith(code.split('-')[0]));
            if (voice) break;
        }

        speechSynthesis.cancel();
        const u = new SpeechSynthesisUtterance(word);
        u.lang = codes[0];
        if (voice) u.voice = voice;
        u.rate = 0.8;
        speechSynthesis.speak(u);
    };

    // Voices load async in some browsers
    if (speechSynthesis.getVoices().length === 0) {
        speechSynthesis.onvoiceschanged = () => {};
    }
    </script>
@endsection
