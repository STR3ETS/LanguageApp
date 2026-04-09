<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#08080c">
    <title>{{ config('app.name', 'Fluence') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-text antialiased bg-night">
    <div class="min-h-screen flex">

        {{-- Left panel — branding & visual --}}
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col py-8 px-12">
            {{-- Background --}}
            <div class="absolute inset-0 bg-gradient-to-br from-indigo/10 via-surface to-night"></div>
            <div class="absolute top-[10%] left-[20%] w-[500px] h-[500px] bg-indigo/8 rounded-full blur-[180px] animate-[blob1_18s_ease-in-out_infinite]"></div>
            <div class="absolute bottom-[10%] right-[15%] w-[400px] h-[400px] bg-indigo/5 rounded-full blur-[150px] animate-[blob2_22s_ease-in-out_infinite]"></div>
            <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(circle, rgba(139,123,245,0.4) 1px, transparent 1px); background-size: 50px 50px;"></div>

            {{-- Logo top-left --}}
            <div class="relative z-10">
                <a href="/" class="inline-flex items-center gap-1.5 group">
                    <span class="text-lg font-display font-bold tracking-wide text-bright group-hover:text-gradient transition-all duration-300">Fluence</span>
                    <span class="w-1 h-1 rounded-full bg-indigo -mt-2"></span>
                </a>
            </div>

            {{-- Centered content --}}
            <div class="relative z-10 max-w-sm mx-auto text-center flex-1 flex flex-col items-center justify-center">
                <h2 class="font-display text-3xl font-bold text-bright tracking-tight mb-4">
                    Master the<br><span class="text-gradient italic">art of language.</span>
                </h2>
                <div class="gold-line mx-auto my-6"></div>
                <p class="text-soft text-sm leading-relaxed mb-10">Join thousands of learners making progress every day with elegant, bite-sized lessons.</p>

                {{-- Feature cards --}}
                <div class="space-y-3 w-full">
                    <div class="glass-card rounded-xl p-4 text-left flex items-center gap-4">
                        <div class="w-10 h-10 bg-indigo/15 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-fire-flame-curved text-indigo-light text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-bright">Daily streaks</div>
                            <div class="text-xs text-muted">Build consistency with streak tracking</div>
                        </div>
                    </div>
                    <div class="glass-card rounded-xl p-4 text-left flex items-center gap-4">
                        <div class="w-10 h-10 bg-mint/15 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-brain text-mint-light text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-bright">Spaced repetition</div>
                            <div class="text-xs text-muted">Science-backed memorization</div>
                        </div>
                    </div>
                    <div class="glass-card rounded-xl p-4 text-left flex items-center gap-4">
                        <div class="w-10 h-10 bg-sun/15 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-globe text-sun-light text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-bright">2 languages</div>
                            <div class="text-xs text-muted">All included with one subscription</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right panel — form --}}
        <div class="w-full lg:w-1/2 flex flex-col justify-center px-6 py-8 relative">
            <div class="absolute inset-0 overflow-hidden pointer-events-none lg:hidden">
                <div class="absolute top-[-20%] left-[30%] w-[400px] h-[400px] bg-indigo/5 rounded-full blur-[150px]"></div>
            </div>

            <div class="relative w-full max-w-md mx-auto">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
