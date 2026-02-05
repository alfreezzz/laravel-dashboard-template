{{--
    Component: input
    Usage: <x-form.input label="Nama" name="name" :value="$model->name" />
    Props:
        - label (optional): string - label text.
        - type (optional): string - input type (default: 'text').
        - name (required-ish): string - form name attribute.
        - id (optional): string - element id, defaults to name.
        - value (optional): string - initial value.
        - required (optional): bool - whether to add HTML required attribute.
        - error (optional): string|null - manual error message.
        - placeholder (optional): string.
--}}
@props(['label' => null, 'type' => 'text', 'name' => null, 'id' => null, 'value' => '', 'required' => false, 'error' => null, 'placeholder' => ''])

@php
    $hasError = $error || $errors->has($name);
    $idAttr = $id ?? $name;
@endphp

<div class="mb-4">
    @if($label)
        <label for="{{ $idAttr }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <input 
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $idAttr }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        class="w-full px-4 py-2 rounded-lg border {{ $hasError ? 'border-red-500 dark:border-red-500' : 'border-slate-300 dark:border-slate-700' }} bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
        {{ $attributes }}
    />
    
    @if($hasError)
        <p class="mt-1 text-sm text-red-500 dark:text-red-400">{{ $errors->first($name) }}</p>
    @endif
</div>
