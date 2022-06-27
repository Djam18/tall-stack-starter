@props(['variant' => 'gray', 'size' => 'sm'])

@php
$variants = [
    'gray'    => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300',
    'green'   => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
    'red'     => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
    'blue'    => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
    'yellow'  => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400',
    'brand'   => 'bg-brand-100 dark:bg-brand-900/30 text-brand-700 dark:text-brand-400',
];
$sizes = [
    'xs' => 'px-1.5 py-0.5 text-xs',
    'sm' => 'px-2 py-0.5 text-xs font-medium',
    'md' => 'px-2.5 py-1 text-sm font-medium',
];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full ' . ($variants[$variant] ?? $variants['gray']) . ' ' . ($sizes[$size] ?? $sizes['sm'])]) }}>
    {{ $slot }}
</span>
