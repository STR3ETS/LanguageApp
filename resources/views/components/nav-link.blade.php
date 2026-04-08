@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-3 py-1.5 text-sm font-medium text-bright bg-elevated rounded-lg transition-all duration-200'
    : 'inline-flex items-center px-3 py-1.5 text-sm font-medium text-soft hover:text-bright hover:bg-elevated/50 rounded-lg transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
