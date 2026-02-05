{{--
    Component: checkbox
    Usage: <x-form.checkbox label="Setuju" name="agree" :checked="$model->agree" />
    Props:
        - label (optional): string - label text displayed next to checkbox.
        - name (required-ish): string - form name attribute.
        - id (optional): string - element id, defaults to name.
        - checked (optional): bool - whether checkbox is checked.
        - value (optional): string - checkbox value (default: '1').
        - required (optional): bool - whether to add HTML required attribute.
        - error (optional): string|null - manual error message.
        - description (optional): string - helper text below checkbox.
--}}
@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'checked' => false,
    'value' => '1',
    'required' => false,
    'error' => null,
    'description' => null
])

@php
    $hasError = $error || $errors->has($name);
    $idAttr = $id ?? $name;
    $isChecked = old($name) !== null ? old($name) == $value : $checked;
@endphp

<div class="mb-4">
    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input 
                type="checkbox"
                name="{{ $name }}"
                id="{{ $idAttr }}"
                value="{{ $value }}"
                {{ $isChecked ? 'checked' : '' }}
                {{ $required ? 'required' : '' }}
                class="w-4 h-4 rounded border {{ $hasError ? 'border-red-500 dark:border-red-500' : 'border-slate-300 dark:border-slate-600' }} bg-white dark:bg-slate-800 text-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-0 transition cursor-pointer"
                {{ $attributes }}
            />
        </div>
        
        @if($label)
            <div class="ml-3">
                <label for="{{ $idAttr }}" class="text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                    {{ $label }}
                    @if($required)
                        <span class="text-red-500">*</span>
                    @endif
                </label>
                
                @if($description)
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $description }}</p>
                @endif
            </div>
        @endif
    </div>
    
    @if($hasError)
        <p class="mt-1 text-sm text-red-500 dark:text-red-400">{{ $errors->first($name) }}</p>
    @endif
</div>