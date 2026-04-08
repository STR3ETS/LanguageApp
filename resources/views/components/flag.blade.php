@props(['code', 'size' => 'md'])

@php
$sizes = [
    'xs' => 'w-4 h-4',
    'sm' => 'w-5 h-5',
    'md' => 'w-7 h-7',
    'lg' => 'w-9 h-9',
    'xl' => 'w-12 h-12',
];
$class = $sizes[$size] ?? $sizes['md'];
@endphp

<img
    src="https://flagcdn.com/{{ $code }}.svg"
    alt="{{ $code }}"
    {{ $attributes->merge(['class' => "$class rounded-full object-cover inline-block"]) }}
    loading="lazy"
>
