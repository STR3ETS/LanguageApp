@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-semibold text-soft uppercase tracking-widest mb-2']) }}>
    {{ $value ?? $slot }}
</label>
