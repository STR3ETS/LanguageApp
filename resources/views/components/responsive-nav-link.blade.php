@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full ps-3 pe-4 py-2.5 border-l-2 border-indigo text-start text-sm font-medium text-bright bg-indigo/5 transition-all duration-200'
    : 'block w-full ps-3 pe-4 py-2.5 border-l-2 border-transparent text-start text-sm font-medium text-soft hover:text-bright hover:bg-elevated hover:border-subtle transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
