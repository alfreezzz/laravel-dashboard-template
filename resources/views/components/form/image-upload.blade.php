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
        - helpText (optional): string - additional help text.
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
        'helpText' => null,
])

@php
    $idAttr = $id ?? $name;
    $hasError = $error || ($name ? $errors->has($name) : false);
@endphp

<div class="mb-6">
    @if($label)
        <label for="{{ $idAttr }}" class="block text-sm font-semibold text-slate-900 dark:text-white mb-3">
            {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif

    <div x-data="{ preview: '{{ $preview ?? '' }}', fileName: '' }" class="">
        <input
            x-ref="img"
            id="{{ $idAttr }}"
            name="{{ $name }}"
            type="file"
            accept="{{ $accept }}"
            {{ $required ? 'required' : '' }}
            class="hidden"
            @change="(e) => { 
                const f = e.target.files[0]; 
                if (!f) { 
                    preview = ''; 
                    fileName = '';
                    return; 
                } 
                preview = URL.createObjectURL(f);
                fileName = f.name;
            }"
        />

        <!-- Drag & Drop Area -->
        <div 
            @dragover.prevent="$el.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20')"
            @dragleave.prevent="$el.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20')"
            @drop.prevent="
                $el.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
                const files = $event.dataTransfer.files;
                if (files.length) {
                    $refs.img.files = files;
                    const f = files[0];
                    preview = URL.createObjectURL(f);
                    fileName = f.name;
                }
            "
            class="border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl p-8 text-center cursor-pointer transition hover:border-blue-400 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/10"
            @click="$refs.img.click()"
        >
            <template x-if="!preview">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-900/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-white">Pilih gambar atau drag ke sini</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">PNG, JPG, GIF hingga 2MB</p>
                    </div>
                </div>
            </template>

            <template x-if="preview">
                <div class="space-y-3">
                    <div class="relative inline-block">
                        <img :src="preview" alt="Preview" class="max-w-xs max-h-64 rounded-lg shadow-md" />
                        <button 
                            type="button" 
                            @click.stop="preview=''; $refs.img.value = null; fileName = ''"
                            class="absolute -top-3 -right-3 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-lg transition"
                        >
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">
                        <p x-text="fileName"></p>
                        <button type="button" @click.stop="$refs.img.click()" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium mt-2">Ganti gambar</button>
                    </div>
                </div>
            </template>
        </div>

        @if($helpText)
            <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">{{ $helpText }}</p>
        @endif
    </div>

    @if($hasError)
        <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $errors->first($name) }}</p>
    @endif
</div>
