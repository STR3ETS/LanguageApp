@extends('layouts.admin')

@section('title', 'Languages - Admin')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="font-display text-2xl font-bold text-bright">Languages</h1>
            <p class="text-sm text-muted mt-1">{{ $languages->count() }} languages configured</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($languages as $lang)
                <a href="{{ route('admin.languages.show', $lang) }}" class="glass-card rounded-2xl p-5 group hover:border-indigo/15 transition-all duration-300 cursor-pointer">
                    <div class="flex items-center gap-3 mb-4">
                        <x-flag :code="$lang->flag_code" size="md" />
                        <div>
                            <div class="font-display font-bold text-bright group-hover:text-indigo-light transition-colors">{{ $lang->name }}</div>
                            <div class="text-xs text-muted">{{ $lang->native_name }}</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div>
                            <div class="text-lg font-display font-bold text-bright">{{ $lang->levels_count }}</div>
                            <div class="text-[9px] text-muted uppercase tracking-widest">Lessons</div>
                        </div>
                        <div>
                            <div class="text-lg font-display font-bold text-bright">{{ $lang->levels->sum('lessons_count') }}</div>
                            <div class="text-[9px] text-muted uppercase tracking-widest">Levels</div>
                        </div>
                        <div>
                            <div class="text-lg font-display font-bold text-indigo-light">{{ $lang->subscriptions_count }}</div>
                            <div class="text-[9px] text-muted uppercase tracking-widest">Learners</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
