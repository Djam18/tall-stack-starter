@props(['active' => false])

<a {{ $attributes->merge([
    'class' => 'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors ' .
               ($active
                 ? 'bg-brand-50 dark:bg-brand-900/30 text-brand-700 dark:text-brand-300'
                 : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-100')
]) }}>
    {{ $slot }}
</a>
