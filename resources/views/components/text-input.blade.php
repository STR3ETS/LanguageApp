@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 bg-elevated border border-border/50 rounded-xl text-sm text-text placeholder-muted focus:outline-none focus:border-indigo/40 focus:ring-1 focus:ring-indigo/20 transition-all duration-200']) }}>
