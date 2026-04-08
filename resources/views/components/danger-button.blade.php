<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-danger hover:bg-danger/80 text-white text-sm font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-danger/50 focus:ring-offset-2 focus:ring-offset-night disabled:opacity-40 hover:shadow-[0_0_20px_var(--color-danger-glow)]']) }}>
    {{ $slot }}
</button>
