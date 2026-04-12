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
        - helpText (optional): string - additional help text.
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

    <div x-data="{ files: [], formatSize(bytes) { return bytes < 1024 ? bytes + ' B' : bytes < 1024 * 1024 ? (bytes / 1024).toFixed(1) + ' KB' : (bytes / 1024 / 1024).toFixed(1) + ' MB'; } }" class="mt-1">
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

        <!-- Drag & Drop Area -->
        <div 
            @dragover.prevent="$el.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20')"
            @dragleave.prevent="$el.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20')"
            @drop.prevent="
                $el.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
                const droppedFiles = $event.dataTransfer.files;
                if (droppedFiles.length) {
                    $refs.input.files = droppedFiles;
                    files = Array.from(droppedFiles);
                }
            "
            class="border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl p-8 text-center cursor-pointer transition hover:border-blue-400 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/10"
            @click="$refs.input.click()"
        >
            <template x-if="files.length === 0">
                <div class="flex flex-col items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-900/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-white">Pilih file atau drag ke sini</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">{{ $accept === '*/*' ? 'Semua format file' : 'Format: ' . strtoupper($accept) }}</p>
                    </div>
                </div>
            </template>

            <template x-if="files.length > 0">
                <div class="space-y-4">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-semibold text-slate-900 dark:text-white" x-text="files.length + ' file dipilih'"></span>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-900/50 rounded-lg p-4 space-y-2">
                        <template x-for="(f, i) in files" :key="i">
                            <div class="flex items-center justify-between p-3 bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-slate-100 to-slate-50 dark:from-slate-700 dark:to-slate-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 16.5a1 1 0 11-2 0 1 1 0 012 0zM15 16.5a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h12a1 1 0 001-1V5a1 1 0 00-1-1H3zM15 7H5v8h10V7z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-900 dark:text-white truncate" x-text="f.name"></p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400" x-text="formatSize(f.size)"></p>
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    @click.stop="files = files.filter((_, j) => j !== i); $refs.input.value = ''"
                                    class="ml-2 p-1 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition flex-shrink-0"
                                >
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>

                    <button type="button" @click.stop="$refs.input.click()" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">Pilih file lain</button>
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
