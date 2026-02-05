{{--
    Component: button
    Usage: <x-form.button type="submit" variant="primary">Simpan</x-form.button>
    Props:
        - type (optional): string - button type attribute (default: 'submit').
        - variant (optional): string - visual variant (primary, success, danger, secondary, outline).
        - size (optional): string - size key (sm, md, lg).
--}}
@props(['type' => 'submit', 'variant' => 'primary', 'size' => 'md'])

@php
    $baseClasses = 'font-medium transition-all rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-slate-900 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-sm',
        'lg' => 'px-6 py-3 text-lg',
        default => 'px-4 py-2 text-base',
    };
    
    $variantClasses = match($variant) {
        'primary' => 'bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white focus:ring-blue-500',
        'success' => 'bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-600 text-white focus:ring-green-500',
        'danger' => 'bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600 text-white focus:ring-red-500',
        'secondary' => 'bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-900 dark:text-white focus:ring-slate-500',
        'outline' => 'border-2 border-slate-300 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-900 dark:text-white focus:ring-slate-500',
        default => 'bg-slate-300 hover:bg-slate-400 dark:bg-slate-600 dark:hover:bg-slate-700 text-slate-900 dark:text-white focus:ring-slate-500',
    };
@endphp

<button 
    type="{{ $type }}"
    class="{{ $baseClasses }} {{ $sizeClasses }} {{ $variantClasses }}"
    {{ $attributes }}
>
    {{ $slot }}
</button>
