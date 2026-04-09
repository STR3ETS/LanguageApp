@extends('layouts.dashboard')

@section('content')
    @php $landmarks = config('landmarks'); @endphp

    <div class="py-8 lg:py-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="font-display text-2xl font-bold text-bright">{{ __('ui.your_languages_page') }}</h1>
                    <p class="text-sm text-muted mt-1">{{ __('ui.pick_language_continue') }}</p>
                </div>
                <a href="{{ route('languages.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 glass hover:bg-elevated text-soft hover:text-bright text-sm font-medium rounded-full transition-all duration-200 cursor-pointer">
                    <i class="fa-solid fa-plus text-xs"></i> Add language
                </a>
            </div>

            {{-- Language cards --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($languageProgress as $lp)
                    @php $lm = $landmarks[$lp->language->slug] ?? ['img' => '', 'place' => '']; @endphp
                    <div class="relative rounded-2xl overflow-hidden min-h-[280px] flex flex-col group">
                        <div class="absolute inset-0">
                            <img src="{{ $lm['img'] }}" alt="{{ trans_lang($lp->language->slug) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-void via-void/80 to-void/20"></div>
                        </div>

                        <div class="relative p-4">
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 glass rounded-full">
                                <x-flag :code="$lp->language->flag_code" size="sm" />
                                <span class="text-xs font-semibold text-bright">{{ trans_lang($lp->language->slug) }}</span>
                            </div>
                        </div>

                        <div class="relative mt-auto p-5">
                            <div class="text-[11px] text-white/50 mb-2">
                                <i class="fa-solid fa-layer-group text-[9px] mr-1"></i>{{ $lp->completed_count }} / {{ $lp->total_lessons }} lessons · {{ $lp->progress_percent }}%
                            </div>
                            <div class="w-full bg-white/10 rounded-full h-1.5 mb-5">
                                <div class="bg-gradient-to-r from-indigo to-indigo-light rounded-full h-1.5 transition-all duration-500" style="width: {{ $lp->progress_percent }}%"></div>
                            </div>

                            @if($lp->next_lesson)
                                <a href="{{ route('learn.lesson', $lp->next_lesson) }}" class="group/btn inline-flex items-center justify-center w-full gap-2 px-6 py-3 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_20px_var(--color-indigo-glow)] cursor-pointer">
                                    <i class="fa-solid fa-play text-[10px]"></i>
                                    {{ $lp->next_lesson->title }}
                                    <i class="fa-solid fa-arrow-right text-xs group-hover/btn:translate-x-1 transition-transform duration-300 ml-auto"></i>
                                </a>
                            @else
                                <div class="text-center py-3 bg-mint/15 backdrop-blur-sm rounded-full border border-mint/20">
                                    <span class="text-sm font-semibold text-mint-light"><i class="fa-solid fa-circle-check text-xs mr-1.5"></i>All lessons completed</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection
