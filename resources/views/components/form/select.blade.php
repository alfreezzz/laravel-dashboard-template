{{--
    Component: select
    Usage:
        Simple
        <x-form.select name="category_id" :options="$categories" />

        Searchable + multi-field label
        <x-form.select name="item_code" :options="$items"
            optionValue="code"
            optionLabel="{code} - {name}"
            :searchKeys="['code', 'name']"
            :searchable="true" />

    Props:
        - label (optional): string
        - name (required-ish): string
        - id (optional): string — defaults to name
        - options (optional): array|Collection
        - optionValue (optional): string — key for value (default: 'id')
        - optionLabel (optional): string|array
              string  → plain field name ("name") OR template ("{code} - {name}")
              array   → fields joined by " - " (["code", "name"])
        - optionData (optional): array — extra keys to embed as data-* on hidden input
        - searchKeys (optional): array — fields to search across (auto-derived from optionLabel)
        - value (optional): mixed
        - required (optional): bool
        - error (optional): string|null
        - placeholder (optional): string
        - searchable (optional): bool — show search input inside dropdown (default: false)
        - searchPlaceholder (optional): string
    Notes:
        - Both searchable and non-searchable use the same custom Alpine.js dropdown,
          so the visual appearance is always identical.
        - Requires Alpine.js.
        - Hidden input dispatches native 'change' event on selection.
--}}
@props([
    'label'             => null,
    'name'              => null,
    'id'                => null,
    'options'           => [],
    'optionValue'       => 'id',
    'optionLabel'       => 'name',
    'optionData'        => [],
    'searchKeys'        => [],
    'value'             => '',
    'required'          => false,
    'error'             => null,
    'placeholder'       => 'Pilih...',
    'searchable'        => false,
    'searchPlaceholder' => 'Cari...',
])

@php
    $hasError = $error || $errors->has($name);
    $idAttr   = $id ?? $name;

    // ── Resolve label renderer ────────────────────────────────────────────
    $resolveLabel = function ($item) use ($optionLabel): string {
        if (is_array($optionLabel)) {
            return implode(' - ', array_map(
                fn($k) => is_array($item) ? ($item[$k] ?? '') : ($item->{$k} ?? ''),
                $optionLabel
            ));
        }
        if (str_contains($optionLabel, '{')) {
            return preg_replace_callback('/\{(\w+)\}/', function ($m) use ($item) {
                $key = $m[1];
                return is_array($item) ? ($item[$key] ?? '') : ($item->{$key} ?? '');
            }, $optionLabel);
        }
        return is_array($item) ? ($item[$optionLabel] ?? '') : ($item->{$optionLabel} ?? '');
    };

    // ── Derive searchKeys ─────────────────────────────────────────────────
    if (empty($searchKeys)) {
        if (is_array($optionLabel)) {
            $searchKeys = $optionLabel;
        } elseif (str_contains($optionLabel, '{')) {
            preg_match_all('/\{(\w+)\}/', $optionLabel, $m);
            $searchKeys = $m[1];
        } else {
            $searchKeys = [$optionLabel];
        }
    }

    // ── Normalize options ─────────────────────────────────────────────────
    $normalizedOptions = [];
    if (is_array($options) || $options instanceof \Illuminate\Support\Collection) {
        foreach ($options as $optionKey => $optionItem) {
            $raw   = $optionItem;
            $entry = [];
            if (is_array($optionItem)) {
                $entry['value'] = $optionItem[$optionValue] ?? $optionKey;
                foreach ($optionData as $dk) { $entry[$dk] = $optionItem[$dk] ?? null; }
                foreach ($searchKeys as $sk) { $entry[$sk] = $optionItem[$sk] ?? null; }
            } elseif (is_object($optionItem)) {
                $entry['value'] = $optionItem->{$optionValue};
                foreach ($optionData as $dk) { $entry[$dk] = $optionItem->{$dk} ?? null; }
                foreach ($searchKeys as $sk) { $entry[$sk] = $optionItem->{$sk} ?? null; }
            } else {
                // Simple key => value format e.g. ['Pcs' => 'Pcs'] or [1 => 'Aktif']
                // Label is the value itself; no field resolution needed
                $entry['value'] = $optionKey;
                $entry['label'] = (string) $optionItem;
                foreach ($searchKeys as $sk) { $entry[$sk] = (string) $optionItem; }
                $normalizedOptions[] = (object) $entry;
                continue;
            }
            $entry['label'] = $resolveLabel($raw);
            $normalizedOptions[] = (object) $entry;
        }
    }

    // ── Build Alpine data ─────────────────────────────────────────────────
    $alpineOptions = collect($normalizedOptions)->map(function ($o) use ($optionData, $searchKeys) {
        $item = ['value' => (string)$o->value, 'label' => (string)$o->label];
        foreach ($optionData as $dk) { $item[$dk] = $o->{$dk} ?? null; }
        foreach ($searchKeys as $sk) { $item[$sk] = $o->{$sk} ?? null; }
        return $item;
    })->values()->toJson();

    $selectedValue  = (string) $value;
    $selectedOption = collect($normalizedOptions)->first(fn($o) => (string)$o->value === $selectedValue);
    $selectedLabel  = $selectedOption?->label ?? '';

    $initialDataAttrs = '';
    foreach ($optionData as $dk) {
        $initialDataAttrs .= ' data-' . Str::kebab($dk) . '="' . e($selectedOption?->{$dk} ?? '') . '"';
    }

    $searchKeysJs = '[' . implode(',', array_map(fn($k) => "'$k'", $searchKeys)) . ']';

    $borderClass = $hasError
        ? 'border-red-500 dark:border-red-500'
        : 'border-slate-300 dark:border-slate-700';
@endphp

<div class="mb-4">

    @if($label)
        <label for="{{ $idAttr }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
            {{ $label }}
            @if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif

    {{-- ── Unified Alpine.js dropdown ──────────────────────────────────── --}}
    <div
        x-data="{
            open: false,
            search: '',
            selectedValue: @js($selectedValue),
            selectedLabel: @js($selectedLabel),
            placeholder: @js($placeholder),
            searchable: @js($searchable),
            options: {{ $alpineOptions }},
            searchKeys: {{ $searchKeysJs }},

            get filtered() {
                if (!this.searchable || !this.search) return this.options;
                const q = this.search.toLowerCase();
                return this.options.filter(o =>
                    this.searchKeys.some(k =>
                        String(o[k] ?? '').toLowerCase().includes(q)
                    )
                );
            },

            select(option) {
                this.selectedValue = option.value;
                this.selectedLabel = option.label;
                this.open = false;
                this.search = '';

                this.$nextTick(() => {
                    const el = this.$refs.hiddenInput;
                    el.value = option.value;
                    @foreach($optionData as $dk)
                    el.dataset.{{ Str::camel($dk) }} = (option.{{ $dk }} !== null && option.{{ $dk }} !== undefined) ? option.{{ $dk }} : '';
                    @endforeach
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                });
            },

            clear() {
                this.selectedValue = '';
                this.selectedLabel = '';
                this.search = '';

                this.$nextTick(() => {
                    const el = this.$refs.hiddenInput;
                    el.value = '';
                    @foreach($optionData as $dk)
                    el.dataset.{{ Str::camel($dk) }} = '';
                    @endforeach
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                });
            },

            isSelected(val) { return this.selectedValue === val; }
        }"
        x-on:keydown.escape="open = false"
        x-on:click.outside="open = false"
        class="relative"
        {{ $attributes->only(['wire:model', 'wire:model.live', 'wire:model.defer', 'class']) }}
    >
        {{-- Hidden input --}}
        <input
            type="hidden"
            name="{{ $name }}"
            id="{{ $idAttr }}"
            x-ref="hiddenInput"
            x-bind:value="selectedValue"
            {{ $required ? 'required' : '' }}
            {!! $initialDataAttrs !!}
        >

        {{-- Trigger button --}}
        <button
            type="button"
            x-on:click="open = !open"
            x-bind:aria-expanded="open"
            aria-haspopup="listbox"
            class="w-full px-4 py-2 rounded-lg border {{ $borderClass }} bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition flex items-center justify-between gap-2 text-left cursor-pointer"
            x-bind:class="{ 'ring-2 ring-blue-500 border-transparent': open }"
        >
            <span
                class="truncate"
                x-bind:class="selectedLabel ? 'text-slate-900 dark:text-white' : 'text-slate-400 dark:text-slate-500'"
                x-text="selectedLabel || placeholder"
            ></span>

            <span class="flex items-center gap-1 shrink-0">
                {{-- Clear button --}}
                <span
                    x-show="selectedValue"
                    x-on:click.stop="clear()"
                    title="Hapus pilihan"
                    class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </span>
                {{-- Chevron --}}
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 text-slate-400 transition-transform duration-200"
                    x-bind:class="{ 'rotate-180': open }"
                    viewBox="0 0 20 20" fill="currentColor"
                >
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                </svg>
            </span>
        </button>

        {{-- Dropdown panel --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute z-50 mt-1 w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-lg"
            role="listbox"
            style="display: none;"
        >
            {{-- Search input — hanya tampil jika searchable=true --}}
            <div
                x-show="searchable"
                class="p-2 border-b border-slate-100 dark:border-slate-700"
            >
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-2.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                    </svg>
                    <input
                        type="text"
                        x-model="search"
                        x-ref="searchInput"
                        x-on:click.stop
                        x-init="$watch('open', val => {
                            if (val && searchable) $nextTick(() => $refs.searchInput.focus())
                        })"
                        placeholder="{{ $searchPlaceholder }}"
                        class="w-full pl-8 pr-3 py-1.5 text-sm rounded-md border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    >
                </div>
            </div>

            {{-- Options list --}}
            <ul class="max-h-56 overflow-y-auto py-1" role="listbox">
                <li
                    x-show="filtered.length === 0"
                    class="px-4 py-3 text-sm text-slate-400 dark:text-slate-500 text-center select-none"
                >Tidak ada hasil ditemukan.</li>

                <template x-for="option in filtered" :key="option.value">
                    <li
                        role="option"
                        x-bind:aria-selected="isSelected(option.value)"
                        x-on:click="select(option)"
                        class="flex items-center justify-between px-4 py-2 text-sm cursor-pointer select-none transition-colors text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-700"
                        x-bind:class="{ 'bg-blue-50 dark:bg-slate-700 font-medium text-blue-600 dark:text-blue-400': isSelected(option.value) }"
                    >
                        <span x-text="option.label"></span>
                        <svg x-show="isSelected(option.value)" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </li>
                </template>
            </ul>
        </div>

    </div>
    {{-- ── end Alpine dropdown ──────────────────────────────────────────── --}}

    @if($hasError)
        <p class="mt-1 text-sm text-red-500 dark:text-red-400">{{ $error ?? $errors->first($name) }}</p>
    @endif

</div>