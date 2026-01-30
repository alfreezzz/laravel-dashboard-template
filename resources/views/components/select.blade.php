{{--
    Component: select
    Usage: <x-select label="Kategori" name="category_id" :options="$categories" optionValue="id" optionLabel="name" :value="$model->category_id" />
    Props:
        - label (optional): string - label text.
        - name (required-ish): string - form field name.
        - id (optional): string - element id, defaults to name.
        - options (optional): array|Collection - options to display. If empty, use slot for custom options.
        - optionValue (optional): string - property/key for option values (default: 'id').
        - optionLabel (optional): string - property/key for option labels (default: 'name').
        - value (optional): mixed - selected value.
        - required (optional): bool.
        - error (optional): string|null - validation message.
        - placeholder (optional): string - default placeholder.
    Notes:
        - Supports array, collection, object items and raw slot fallback.
--}}
@props([
        'label' => null,
        'name' => null,
        'id' => null,
        'options' => [],
        'optionValue' => 'id',
        'optionLabel' => 'name',
        'value' => '',
        'required' => false,
        'error' => null,
        'placeholder' => 'Pilih...'
])

@php
    $hasError = $error || $errors->has($name);
    $idAttr = $id ?? $name;
    
    // Normalize options - handle both arrays and collections
    $normalizedOptions = [];
    if (is_array($options) || $options instanceof \Illuminate\Support\Collection) {
        foreach ($options as $optionKey => $optionItem) {
            if (is_array($optionItem)) {
                // Array format: ['value' => 'key', 'label' => 'display']
                $normalizedOptions[] = (object)[
                    'value' => $optionItem[$optionValue] ?? $optionKey,
                    'label' => $optionItem[$optionLabel] ?? $optionItem
                ];
            } elseif (is_object($optionItem)) {
                // Object format (Eloquent model, etc)
                $normalizedOptions[] = (object)[
                    'value' => $optionItem->{$optionValue},
                    'label' => $optionItem->{$optionLabel}
                ];
            } else {
                // Simple key=>value format
                $normalizedOptions[] = (object)[
                    'value' => $optionKey,
                    'label' => $optionItem
                ];
            }
        }
    }
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
    
    <select 
        name="{{ $name }}"
        id="{{ $idAttr }}"
        {{ $required ? 'required' : '' }}
        class="w-full px-4 py-2 rounded-lg border {{ $hasError ? 'border-red-500 dark:border-red-500' : 'border-slate-300 dark:border-slate-700' }} bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition cursor-pointer"
        {{ $attributes }}
    >
        <option value="">{{ $placeholder }}</option>
        
        @if(count($normalizedOptions) > 0)
            @foreach($normalizedOptions as $option)
                <option value="{{ $option->value }}" {{ (string)$value === (string)$option->value ? 'selected' : '' }}>
                    {{ $option->label }}
                </option>
            @endforeach
        @else
            {{ $slot }}
        @endif
    </select>
    
    @if($hasError)
        <p class="mt-1 text-sm text-red-500 dark:text-red-400">{{ $errors->first($name) }}</p>
    @endif
</div>
