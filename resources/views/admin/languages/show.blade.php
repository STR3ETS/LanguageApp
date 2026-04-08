@extends('layouts.admin')

@section('title', $language->name . ' - Admin')

@section('content')
<div class="py-8">
    <div class="max-w-5xl mx-auto px-6 lg:px-8">

        <a href="{{ route('admin.languages.index') }}" class="inline-flex items-center gap-2 text-sm text-muted hover:text-indigo-light transition-colors mb-6 cursor-pointer">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to languages
        </a>

        {{-- Header --}}
        <div class="glass-card rounded-2xl p-6 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-elevated flex items-center justify-center">
                    <x-flag :code="$language->flag_code" size="lg" />
                </div>
                <div>
                    <h1 class="font-display text-2xl font-bold text-bright">{{ $language->name }}</h1>
                    <div class="text-sm text-muted">{{ $language->native_name }} · {{ $language->levels->count() }} lessons · {{ $language->levels->sum(fn($l) => $l->lessons->count()) }} levels</div>
                </div>
            </div>
        </div>

        {{-- CEFR breakdown --}}
        @php $cefrGroups = $language->levels->groupBy('cefr'); @endphp
        <div class="space-y-6">
            @foreach($cefrGroups as $cefr => $levels)
                <div>
                    <h2 class="text-sm font-semibold text-muted uppercase tracking-widest mb-3">{{ $cefr }} — {{ $levels->count() }} lessons · {{ $levels->sum('lessons_count') }} levels</h2>

                    <div class="space-y-3">
                        @foreach($levels as $level)
                            <div class="glass-card rounded-2xl overflow-hidden" x-data="{ open: false }">
                                <button @click="open = !open" class="w-full px-5 py-4 flex items-center justify-between cursor-pointer hover:bg-elevated/20 transition-colors focus:outline-none">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-indigo/10 rounded-xl flex items-center justify-center shrink-0">
                                            <span class="text-xs font-bold text-indigo-light">{{ $level->number }}</span>
                                        </div>
                                        <div class="text-left">
                                            <div class="font-semibold text-bright text-sm">{{ $level->name }}</div>
                                            <div class="text-[11px] text-muted">{{ $level->description }} · {{ $level->lessons_count }} levels · {{ $level->xp_required }} XP req.</div>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-chevron-down text-[10px] text-muted transition-transform" :class="open && 'rotate-180'"></i>
                                </button>

                                <div x-show="open" x-collapse>
                                    <div class="border-t border-border/20 divide-y divide-border/15">
                                        @foreach($level->lessons as $lesson)
                                            <div class="px-5 py-3 flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-7 h-7 bg-elevated rounded-lg flex items-center justify-center">
                                                        <span class="text-[10px] text-muted">{{ $loop->iteration }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm text-bright">{{ $lesson->title }}</div>
                                                        <div class="text-[10px] text-muted">{{ $lesson->description }}</div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-3 text-xs">
                                                    <span class="px-2 py-0.5 bg-elevated rounded-full text-muted text-[10px]">{{ ucfirst($lesson->type) }}</span>
                                                    <span class="text-indigo-light font-semibold">+{{ $lesson->xp_reward }} XP</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
