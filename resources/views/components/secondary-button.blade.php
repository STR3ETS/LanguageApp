<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-elevated border border-border hover:bg-card hover:border-subtle text-text text-sm font-semibold rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo/30 focus:ring-offset-2 focus:ring-offset-night disabled:opacity-40']) }}>
    {{ $slot }}
</button>
