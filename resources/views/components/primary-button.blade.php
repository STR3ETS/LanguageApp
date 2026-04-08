<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3.5 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-indigo/50 focus:ring-offset-2 focus:ring-offset-night disabled:opacity-40 hover:shadow-[0_0_30px_var(--color-indigo-glow)] cursor-pointer']) }}>
    {{ $slot }}
</button>
