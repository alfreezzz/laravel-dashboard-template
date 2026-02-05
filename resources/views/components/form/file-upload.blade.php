{{--
    Component: file-upload
    Usage: <x-form.file-upload label="File" name="attachments" :multiple="true" />
    Props:
        - label (optional): string - label text.
        - name (required-ish): string - form field name.
        - id (optional): string - element id, defaults to name.
        - accept (optional): string - accepted MIME types (default '*/*').
        - multiple (optional): bool - allow multiple file selection.
        - required (optional): bool - HTML required attribute.
        - error (optional): string|null - manual validation message.
    Notes:
        - The component uses Alpine to show selected file list; server-side validation still required.
--}}
@props([
        'label' => null,
        'name' => null,
        'id' => null,
        'accept' => '*/*',
        'multiple' => false,
        'required' => false,
        'error' => null,
])

@php
    $idAttr = $id ?? $name;
    $hasError = $error || ($name ? $errors->has($name) : false);
@endphp

<div class="mb-4">
    @if($label)
        <label for="{{ $idAttr }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
            {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif

    <div x-data="{ files: [] }" class="mt-1">
        <input
            x-ref="input"
            id="{{ $idAttr }}"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            type="file"
            accept="{{ $accept }}"
            {{ $multiple ? 'multiple' : '' }}
            {{ $required ? 'required' : '' }}
            class="hidden"
            @change="files = Array.from($event.target.files)"
        />

        <div class="flex items-center gap-2">
            <button type="button" @click="$refs.input.click()" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-md text-sm transition">
                Pilih File
            </button>
            <div class="text-sm text-slate-600 dark:text-slate-400" x-text="files.length ? files.length + (files.length > 1 ? ' file dipilih' : ' file dipilih') : 'Belum ada file'"></div>
        </div>

        <template x-if="files.length">
            <ul class="mt-2 space-y-1 text-sm text-slate-600 dark:text-slate-400">
                <template x-for="(f, i) in files" :key="i">
                    <li class="flex items-center justify-between">
                        <span x-text="f.name"></span>
                        <span class="text-xs text-slate-500" x-text="(f.size / 1024).toFixed(0) + ' KB'"></span>
                    </li>
                </template>
            </ul>
        </template>
    </div>

    @if($hasError)
        <p class="mt-1 text-sm text-red-500">{{ $errors->first($name) }}</p>
    @endif
</div>
