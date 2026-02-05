{{--
    Component: image-upload
    Usage: <x-form.image-upload label="Foto" name="image" :preview="$model->image_url" />
    Props:
        - label (optional): string - label text.
        - name (required-ish): string - form field name.
        - id (optional): string - element id, defaults to name.
        - accept (optional): string - accepted MIME types (default: 'image/*').
        - required (optional): bool - add HTML required attribute.
        - preview (optional): string - URL of existing preview image to show initially.
        - error (optional): string|null - manual error message.
        - placeholder (optional): string - text shown when no preview.
    Notes:
        - Preview is client-side via Alpine; server-side validation for size/type is still recommended.
--}}
@props([
        'label' => null,
        'name' => null,
        'id' => null,
        'accept' => 'image/*',
        'required' => false,
        'preview' => null,
        'error' => null,
        'placeholder' => null,
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

    <div x-data="{ preview: '{{ $preview ?? '' }}' }" class="">
        <input
            x-ref="img"
            id="{{ $idAttr }}"
            name="{{ $name }}"
            type="file"
            accept="{{ $accept }}"
            {{ $required ? 'required' : '' }}
            class="hidden"
            @change="(e) => { const f = e.target.files[0]; if (!f) { preview = ''; return; } preview = URL.createObjectURL(f); }"
        />

        <div class="flex items-center gap-4">
            <div class="w-24 h-24 bg-slate-100 dark:bg-slate-900 rounded-md overflow-hidden flex items-center justify-center">
                <template x-if="preview">
                    <img :src="preview" alt="Preview" class="w-full h-full object-cover" />
                </template>
                <template x-if="!preview">
                    <div class="text-xs text-slate-500 text-center px-2">{{ $placeholder ?? 'Preview' }}</div>
                </template>
            </div>

            <div class="flex flex-col gap-2">
                <div class="flex gap-2">
                    <button type="button" @click="$refs.img.click()" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-md text-sm transition">Pilih Gambar</button>
                    <button type="button" @click="preview=''; $refs.img.value = null" class="px-3 py-2 bg-slate-50 hover:bg-slate-100 dark:bg-slate-900 dark:hover:bg-slate-800 rounded-md text-sm transition">Hapus</button>
                </div>
                <div class="text-sm text-slate-600 dark:text-slate-400">Rekomendasi: max 2MB</div>
            </div>
        </div>
    </div>

    @if($hasError)
        <p class="mt-1 text-sm text-red-500">{{ $errors->first($name) }}</p>
    @endif
</div>
