@props(['label', 'value', 'icon' => null, 'trend' => null, 'trendUp' => true])

<div class="card p-6">
    <div class="flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $value }}</p>
            @if($trend)
                <p class="mt-1 flex items-center gap-1 text-sm {{ $trendUp ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                    <span>{{ $trendUp ? '↑' : '↓' }}</span>
                    {{ $trend }}
                </p>
            @endif
        </div>
        @if($icon)
            <div class="text-3xl">{{ $icon }}</div>
        @endif
    </div>
</div>
