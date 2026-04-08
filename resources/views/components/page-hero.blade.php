@props(['title', 'highlight' => '', 'subtitle' => '', 'badge' => '', 'badgeIcon' => 'fa-solid fa-star', 'badgeColor' => 'indigo'])

<section class="relative py-24 lg:py-32 overflow-hidden">
    {{-- Background blobs --}}
    <div class="absolute top-[10%] left-[20%] w-[500px] h-[500px] bg-indigo/4 rounded-full blur-[180px]"></div>
    <div class="absolute bottom-[10%] right-[15%] w-[350px] h-[350px] bg-{{ $badgeColor }}/3 rounded-full blur-[140px]"></div>
    <div class="absolute inset-0 opacity-[0.015]" style="background-image: radial-gradient(circle, rgba(139,123,245,0.4) 1px, transparent 1px); background-size: 50px 50px;"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8 text-center">
        @if($badge)
            <div class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full mb-6 text-xs font-medium text-soft tracking-widest uppercase">
                <i class="{{ $badgeIcon }} text-{{ $badgeColor }}-light text-[10px]"></i>
                {{ $badge }}
            </div>
        @endif

        <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-bright tracking-tight mb-5">
            {!! $title !!}
            @if($highlight)
                <br><span class="text-gradient italic">{{ $highlight }}</span>
            @endif
        </h1>

        @if($subtitle)
            <p class="text-lg text-soft max-w-2xl mx-auto leading-relaxed">{{ $subtitle }}</p>
        @endif

        <div class="gold-line mx-auto mt-8"></div>
    </div>
</section>
