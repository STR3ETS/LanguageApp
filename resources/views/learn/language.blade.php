@extends('layouts.dashboard')

@section('content')
    @php
        $totalLessons = $language->levels->sum(fn($l) => $l->lessons->count());
        $totalCompleted = $language->levels->sum(fn($l) => $l->lessons->filter(fn($ls) => $completedLessonIds->contains($ls->id))->count());
        $overallPercent = $totalLessons > 0 ? round(($totalCompleted / $totalLessons) * 100) : 0;

        $cefrLevels = $language->levels->groupBy('cefr');
        $cefrStats = [];
        $prevCefrKey = null;
        foreach ($cefrLevels as $cefr => $levels) {
            $total = $levels->sum(fn($l) => $l->lessons->count());
            $done = $levels->sum(fn($l) => $l->lessons->filter(fn($ls) => $completedLessonIds->contains($ls->id))->count());
            $isComplete = $done === $total && $total > 0;
            $isLocked = $prevCefrKey !== null && !$cefrStats[$prevCefrKey]['complete'];
            $cefrStats[$cefr] = ['total' => $total, 'done' => $done, 'percent' => $total > 0 ? round(($done / $total) * 100) : 0, 'complete' => $isComplete, 'locked' => $isLocked];
            $prevCefrKey = $cefr;
        }

        $cefrMeta = [
            'A1' => ['label' => 'Beginner', 'icon' => 'fa-seedling', 'color' => 'mint'],
            'A2' => ['label' => 'Elementary', 'icon' => 'fa-leaf', 'color' => 'sky'],
            'B1' => ['label' => 'Intermediate', 'icon' => 'fa-tree', 'color' => 'indigo'],
            'B2' => ['label' => 'Upper Intermediate', 'icon' => 'fa-mountain', 'color' => 'sun'],
            'C1' => ['label' => 'Advanced', 'icon' => 'fa-crown', 'color' => 'rose'],
            'C2' => ['label' => 'Mastery', 'icon' => 'fa-gem', 'color' => 'indigo'],
        ];

        $globalLessonNum = 0;
    @endphp

    <div class="py-8 lg:py-10">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">

            {{-- ===== HEADER ===== --}}
            <div class="relative rounded-3xl overflow-hidden mb-10">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo/15 via-surface to-indigo/8 animate-[ctaGradient_8s_ease-in-out_infinite_alternate]"></div>
                <div class="absolute inset-0 bg-gradient-to-tl from-indigo/8 via-transparent to-indigo/10 animate-[ctaGradient2_10s_ease-in-out_infinite_alternate]"></div>
                <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-indigo/8 rounded-full blur-[150px] animate-[blob1_18s_ease-in-out_infinite]"></div>
                <div class="absolute bottom-0 left-[20%] w-[300px] h-[300px] bg-indigo/6 rounded-full blur-[120px] animate-[blob2_22s_ease-in-out_infinite]"></div>

                <div class="relative px-8 py-8 lg:py-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 flex items-center justify-center">
                            <x-flag :code="$language->flag_code" size="lg" />
                        </div>
                        <div>
                            <h1 class="font-display text-2xl font-bold text-bright">{{ $language->name }}</h1>
                            <div class="flex items-center gap-3 mt-1.5">
                                <div class="w-28 bg-white/10 rounded-full h-1.5">
                                    <div class="bg-gradient-to-r from-indigo to-indigo-light rounded-full h-1.5" style="width: {{ $overallPercent }}%"></div>
                                </div>
                                <span class="text-xs text-soft">{{ $totalCompleted }}/{{ $totalLessons }} levels · {{ $overallPercent }}%</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('learn.index') }}" class="text-xs text-soft hover:text-indigo-light transition-colors flex items-center gap-1.5 cursor-pointer shrink-0">
                        <i class="fa-solid fa-arrow-left text-[9px]"></i> All languages
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 px-5 py-4 glass-card rounded-2xl border-mint/20 text-sm text-mint-light flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            {{-- ===== CEFR SECTIONS ===== --}}
            <div class="space-y-12">
                @foreach ($cefrLevels as $cefr => $levels)
                    @php
                        $meta = $cefrMeta[$cefr] ?? ['label' => $cefr, 'icon' => 'fa-circle', 'color' => 'indigo'];
                        $cefrLocked = $cefrStats[$cefr]['locked'];
                        $cefrComplete = $cefrStats[$cefr]['complete'];
                    @endphp

                    <div class="{{ $cefrLocked ? 'opacity-40 pointer-events-none' : '' }}">
                        {{-- CEFR Header --}}
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 rounded-2xl {{ $cefrLocked ? 'bg-elevated' : ($cefrComplete ? 'bg-mint/10' : 'bg-' . $meta['color'] . '/10') }} flex items-center justify-center shrink-0">
                                @if($cefrLocked)
                                    <i class="fa-solid fa-lock text-muted text-sm"></i>
                                @elseif($cefrComplete)
                                    <i class="fa-solid fa-circle-check text-mint-light text-lg"></i>
                                @else
                                    <i class="fa-solid {{ $meta['icon'] }} text-{{ $meta['color'] }}-light text-lg"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h2 class="font-display text-xl font-bold {{ $cefrLocked ? 'text-muted' : 'text-bright' }}">{{ $cefr }} — {{ $meta['label'] }}</h2>
                                    @if($cefrLocked)
                                        <span class="text-[10px] px-2 py-0.5 bg-elevated rounded-full text-muted">
                                            <i class="fa-solid fa-lock text-[8px] mr-0.5"></i> Complete {{ array_keys($cefrStats)[array_search($cefr, array_keys($cefrStats)) - 1] }} first
                                        </span>
                                    @elseif($cefrComplete)
                                        <span class="text-[10px] px-2.5 py-0.5 bg-mint/10 rounded-full text-mint-light font-semibold">Completed</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 mt-1.5">
                                    <div class="w-32 bg-elevated rounded-full h-1.5">
                                        <div class="bg-{{ $cefrComplete ? 'mint' : $meta['color'] }} rounded-full h-1.5 transition-all" style="width: {{ $cefrStats[$cefr]['percent'] }}%"></div>
                                    </div>
                                    <span class="text-[11px] text-muted">{{ $cefrStats[$cefr]['done'] }}/{{ $cefrStats[$cefr]['total'] }} levels</span>
                                </div>
                            </div>
                        </div>

                        {{-- Lessons (DB "levels") within this CEFR --}}
                        <div class="space-y-4">
                            @foreach($levels as $level)
                                @php
                                    $globalLessonNum++;
                                    $levelLessons = $level->lessons;
                                    $completedInLevel = $levelLessons->filter(fn($l) => $completedLessonIds->contains($l->id))->count();
                                    $levelTotal = $levelLessons->count();
                                    $isLevelComplete = $completedInLevel === $levelTotal && $levelTotal > 0;
                                    $levelPercent = $levelTotal > 0 ? round(($completedInLevel / $levelTotal) * 100) : 0;
                                    $hasUnlocked = $levelLessons->contains(fn($l) => $unlockedLessonIds->contains($l->id) || $completedLessonIds->contains($l->id));
                                @endphp

                                <div class="glass-card rounded-2xl overflow-hidden {{ $isLevelComplete ? 'border-mint/10' : '' }}" x-data="{ open: {{ ($hasUnlocked && !$isLevelComplete) ? 'true' : 'false' }} }">
                                    {{-- Lesson header --}}
                                    <button @click="open = !open" class="w-full px-5 py-4 flex items-center gap-4 cursor-pointer hover:bg-elevated/20 transition-colors duration-200 focus:outline-none">
                                        {{-- Number badge --}}
                                        <div class="w-11 h-11 rounded-xl {{ $isLevelComplete ? 'bg-mint/15' : ($hasUnlocked ? 'bg-' . $meta['color'] . '/15' : 'bg-elevated/80') }} flex items-center justify-center shrink-0">
                                            @if($isLevelComplete)
                                                <i class="fa-solid fa-circle-check text-mint-light text-sm"></i>
                                            @elseif(!$hasUnlocked)
                                                <i class="fa-solid fa-lock text-muted text-[10px]"></i>
                                            @else
                                                <span class="text-sm font-display font-bold text-{{ $meta['color'] }}-light">{{ $globalLessonNum }}</span>
                                            @endif
                                        </div>

                                        <div class="flex-1 text-left min-w-0">
                                            <div class="flex items-center gap-2">
                                                <h3 class="font-display font-bold text-bright text-sm">Les {{ $globalLessonNum }}: {{ $level->name }}</h3>
                                            </div>
                                            <div class="text-[11px] text-muted mt-0.5">
                                                @if($level->description){{ $level->description }} · @endif{{ $completedInLevel }}/{{ $levelTotal }} levels
                                            </div>
                                        </div>

                                        {{-- Progress --}}
                                        <div class="hidden sm:flex items-center gap-3 shrink-0">
                                            @if($isLevelComplete)
                                                <span class="text-[10px] px-2 py-0.5 bg-mint/10 text-mint-light rounded-full font-semibold">Done</span>
                                            @elseif($levelPercent > 0)
                                                <div class="flex items-center gap-2">
                                                    <div class="w-16 bg-elevated rounded-full h-1.5">
                                                        <div class="bg-{{ $meta['color'] }} rounded-full h-1.5" style="width: {{ $levelPercent }}%"></div>
                                                    </div>
                                                    <span class="text-[10px] text-{{ $meta['color'] }}-light font-semibold">{{ $levelPercent }}%</span>
                                                </div>
                                            @endif
                                        </div>

                                        <i class="fa-solid fa-chevron-down text-[10px] text-muted transition-transform duration-200 shrink-0" :class="open && 'rotate-180'"></i>
                                    </button>

                                    {{-- Levels (DB "lessons") within this Lesson --}}
                                    <div x-show="open" x-collapse>
                                        <div class="px-5 pb-4">
                                            <div>
                                                @foreach($levelLessons as $lessonIndex => $lesson)
                                                    @php
                                                        $isCompleted = $completedLessonIds->contains($lesson->id);
                                                        $isUnlocked = $unlockedLessonIds->contains($lesson->id) || $isCompleted;
                                                        $isLocked = !$isUnlocked;
                                                        $levelNum = $lessonIndex + 1;
                                                        $isNext = $isUnlocked && !$isCompleted;
                                                        $isLast = $loop->last;
                                                        $nextIsCompleted = !$isLast && $completedLessonIds->contains($levelLessons[$lessonIndex + 1]->id ?? 0);
                                                    @endphp

                                                    {{-- Level item --}}
                                                    @if($isLocked)
                                                        <div class="flex items-center gap-4 pl-2 py-2.5 opacity-50">
                                                            <div class="w-9 h-9 rounded-xl bg-elevated flex items-center justify-center shrink-0">
                                                                <i class="fa-solid fa-lock text-muted text-[9px]"></i>
                                                            </div>
                                                            <div class="flex-1 min-w-0">
                                                                <div class="text-sm text-muted">Level {{ $levelNum }}: {{ $lesson->title }}</div>
                                                                <div class="text-[10px] text-muted flex items-center gap-2">
                                                                    <span>{{ ucfirst($lesson->type) }}</span>
                                                                    <span>+{{ $lesson->xp_reward }} XP</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <a href="{{ $isCompleted ? route('learn.review', $lesson) : route('learn.lesson', $lesson) }}" class="flex items-center gap-4 pl-2 py-2.5 rounded-xl hover:bg-elevated/40 transition-all duration-200 group cursor-pointer">
                                                            <div class="w-9 h-9 rounded-xl {{ $isCompleted ? 'bg-mint/15' : 'bg-indigo/15 ring-2 ring-indigo/30' }} flex items-center justify-center shrink-0">
                                                                @if($isCompleted)
                                                                    <i class="fa-solid fa-check text-mint-light text-xs"></i>
                                                                @else
                                                                    <i class="fa-solid fa-play text-indigo-light text-[9px]"></i>
                                                                @endif
                                                            </div>
                                                            <div class="flex-1 min-w-0">
                                                                <div class="text-sm font-medium {{ $isNext ? 'text-bright' : 'text-text' }} group-hover:text-bright transition-colors">Level {{ $levelNum }}: {{ $lesson->title }}</div>
                                                                <div class="text-[10px] text-muted flex items-center gap-2">
                                                                    <span>{{ ucfirst($lesson->type) }}</span>
                                                                    <span>+{{ $lesson->xp_reward }} XP</span>
                                                                    @if($isCompleted)
                                                                        <span class="text-mint-light"><i class="fa-solid fa-eye text-[8px] mr-0.5"></i>Review</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @if($isNext)
                                                                <div class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo/10 rounded-full text-[10px] text-indigo-light font-semibold group-hover:bg-indigo/15 transition-colors">
                                                                    <i class="fa-solid fa-play text-[7px]"></i> Start
                                                                </div>
                                                            @elseif($isCompleted)
                                                                <div class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 bg-mint/10 rounded-full text-[10px] text-mint-light font-semibold group-hover:bg-mint/15 transition-colors">
                                                                    <i class="fa-solid fa-eye text-[7px]"></i> Review
                                                                </div>
                                                            @else
                                                                <i class="fa-solid fa-chevron-right text-[9px] text-subtle group-hover:text-indigo-light group-hover:translate-x-0.5 transition-all duration-200 shrink-0"></i>
                                                            @endif
                                                        </a>
                                                    @endif

                                                    {{-- Connector line between items --}}
                                                    @if(!$isLast)
                                                        <div class="flex justify-start pl-2">
                                                            <div class="w-9 flex justify-center">
                                                                <div class="w-0.5 h-3 rounded-full {{ $isCompleted ? 'bg-mint/40' : 'bg-border/20' }}"></div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
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
