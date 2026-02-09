{{--
    Component: badge
    Usage: <x-badge color="blue" size="sm">Badge Text</x-badge>
    Props:
        - color (optional): string - one of 'blue', 'purple', 'emerald', 'red', 'yellow', 'gray', 'indigo', 'pink' (default: 'blue').
        - size (optional): string - one of 'xs', 'sm', 'md', 'lg' (default: 'xs').
        - variant (optional): string - one of 'solid', 'outline' (default: 'solid').
        - rounded (optional): string - one of 'full', 'md', 'lg' (default: 'full').
        - prefix (optional): string - text or icon to show before content (e.g., '#').
    Slot:
        - default: badge content/text
--}}
@props([
    'color' => 'blue',
    'size' => 'xs',
    'variant' => 'solid',
    'rounded' => 'full',
    'prefix' => null
])

@php
    // Size classes
    $sizeClasses = match($size) {
        'xs' => 'px-2 py-0.5 text-xs',
        'sm' => 'px-2.5 py-1 text-sm',
        'md' => 'px-3 py-1.5 text-base',
        'lg' => 'px-4 py-2 text-lg',
        default => 'px-2 py-0.5 text-xs',
    };

    // Rounded classes
    $roundedClasses = match($rounded) {
        'full' => 'rounded-full',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        default => 'rounded-full',
    };

    // Color classes based on variant
    if ($variant === 'solid') {
        $colorClasses = match($color) {
            'blue' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
            'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
            'emerald' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
            'red' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
            'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
            'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300',
            'indigo' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
            'pink' => 'bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-300',
            'orange' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300',
            'teal' => 'bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-300',
            default => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
        };
    } else {
        $colorClasses = match($color) {
            'blue' => 'border border-blue-300 text-blue-700 dark:border-blue-700 dark:text-blue-400',
            'purple' => 'border border-purple-300 text-purple-700 dark:border-purple-700 dark:text-purple-400',
            'emerald' => 'border border-emerald-300 text-emerald-700 dark:border-emerald-700 dark:text-emerald-400',
            'red' => 'border border-red-300 text-red-700 dark:border-red-700 dark:text-red-400',
            'yellow' => 'border border-yellow-300 text-yellow-700 dark:border-yellow-700 dark:text-yellow-400',
            'gray' => 'border border-gray-300 text-gray-700 dark:border-gray-700 dark:text-gray-400',
            'indigo' => 'border border-indigo-300 text-indigo-700 dark:border-indigo-700 dark:text-indigo-400',
            'pink' => 'border border-pink-300 text-pink-700 dark:border-pink-700 dark:text-pink-400',
            'orange' => 'border border-orange-300 text-orange-700 dark:border-orange-700 dark:text-orange-400',
            'teal' => 'border border-teal-300 text-teal-700 dark:border-teal-700 dark:text-teal-400',
            default => 'border border-blue-300 text-blue-700 dark:border-blue-700 dark:text-blue-400',
        };
    }
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center font-medium {$sizeClasses} {$colorClasses} {$roundedClasses}"]) }}>
    @if($prefix)
        <span class="mr-0.5">{{ $prefix }}</span>
    @endif
    {{ $slot }}
</span>