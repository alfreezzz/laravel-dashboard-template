{{--
    Component: editor
    Usage: <x-form.editor label="Konten" name="content" :value="$model->content" />
    Props:
        - label (optional): string - label text displayed above editor.
        - name (required-ish): string - form name attribute.
        - id (optional): string - element id, defaults to name.
        - value (optional): string - initial HTML content.
        - required (optional): bool - whether field is required.
        - error (optional): string|null - manual error message.
        - placeholder (optional): string.
        - height (optional): string - editor height (default: '300px').
        - toolbar (optional): string - toolbar preset: 'basic', 'standard', 'full' (default: 'standard').
    
    Note: Requires Quill.js - Add to layout:
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
--}}
@props([
    'label' => null,
    'name' => null,
    'id' => null,
    'value' => '',
    'required' => false,
    'error' => null,
    'placeholder' => 'Tulis sesuatu...',
    'height' => '300px',
    'toolbar' => 'standard'
])

@php
    $hasError = $error || $errors->has($name);
    $idAttr = $id ?? $name;
    $editorId = $idAttr . '_editor';
    $oldValue = old($name, $value);
    
    // Toolbar configurations
    $toolbarConfigs = [
        'basic' => [
            ['bold', 'italic', 'underline'],
            [['list' => 'ordered'], ['list' => 'bullet']],
            ['link']
        ],
        'standard' => [
            [['header' => [1, 2, 3, false]]],
            ['bold', 'italic', 'underline', 'strike'],
            [['list' => 'ordered'], ['list' => 'bullet']],
            ['blockquote', 'code-block'],
            ['link', 'image'],
            ['clean']
        ],
        'full' => [
            [['header' => [1, 2, 3, 4, 5, 6, false]]],
            [['font' => []]],
            [['size' => ['small', false, 'large', 'huge']]],
            ['bold', 'italic', 'underline', 'strike'],
            [['color' => []], ['background' => []]],
            [['script' => 'sub'], ['script' => 'super']],
            [['list' => 'ordered'], ['list' => 'bullet'], ['indent' => '-1'], ['indent' => '+1']],
            [['direction' => 'rtl'], ['align' => []]],
            ['blockquote', 'code-block'],
            ['link', 'image', 'video'],
            ['clean']
        ]
    ];
    
    $toolbarConfig = $toolbarConfigs[$toolbar] ?? $toolbarConfigs['standard'];
@endphp

<div class="mb-6">
    @if($label)
        <label for="{{ $idAttr }}" class="block text-sm font-semibold text-slate-900 dark:text-white mb-3">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div class="editor-wrapper" x-data="{ charCount: {{ strlen(strip_tags($oldValue)) }} }">
        <!-- Editor Wrapper dengan styling modern -->
        <div class="border {{ $hasError ? 'border-red-500 dark:border-red-500' : 'border-slate-300 dark:border-slate-700' }} rounded-xl overflow-hidden shadow-sm transition hover:border-slate-400 dark:hover:border-slate-600 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent">
            
            <!-- Editor Toolbar Customization -->
            <style>
                #{{ $editorId }} {
                    min-height: {{ $height }};
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                    font-size: 15px;
                    line-height: 1.6;
                    color: #1e293b;
                }

                .dark #{{ $editorId }} {
                    background-color: #1e293b;
                    color: #e2e8f0;
                }

                .ql-container {
                    border: none;
                    font-family: inherit;
                    font-size: inherit;
                }

                .ql-editor {
                    padding: 16px;
                    min-height: {{ $height }};
                }

                .ql-editor.ql-blank::before {
                    color: #94a3b8;
                    font-style: normal;
                }

                .dark .ql-editor.ql-blank::before {
                    color: #64748b;
                }

                .ql-toolbar {
                    border: none;
                    border-bottom: 1px solid;
                    border-color: #e2e8f0;
                    background: #f8fafc;
                    padding: 8px 12px;
                    display: flex;
                    gap: 4px;
                    flex-wrap: wrap;
                }

                .dark .ql-toolbar {
                    background-color: #0f172a;
                    border-color: #334155;
                }

                .ql-toolbar.ql-snow .ql-formats {
                    margin-right: 12px;
                    display: flex;
                    gap: 4px;
                    align-items: center;
                }

                .ql-toolbar.ql-snow .ql-stroke {
                    stroke: #64748b;
                }

                .dark .ql-toolbar.ql-snow .ql-stroke {
                    stroke: #cbd5e1;
                }

                .ql-toolbar.ql-snow .ql-fill,
                .ql-toolbar.ql-snow .ql-stroke.ql-fill {
                    fill: #64748b;
                }

                .dark .ql-toolbar.ql-snow .ql-fill,
                .dark .ql-toolbar.ql-snow .ql-stroke.ql-fill {
                    fill: #cbd5e1;
                }

                .ql-toolbar.ql-snow button:hover,
                .ql-toolbar.ql-snow button:focus,
                .ql-toolbar.ql-snow button.ql-active,
                .ql-toolbar.ql-snow .ql-picker-label:hover,
                .ql-toolbar.ql-snow .ql-picker-item:hover,
                .ql-toolbar.ql-snow .ql-picker-item.ql-selected {
                    color: #3b82f6;
                }

                .ql-toolbar.ql-snow button:hover .ql-stroke,
                .ql-toolbar.ql-snow button:focus .ql-stroke,
                .ql-toolbar.ql-snow button.ql-active .ql-stroke,
                .ql-toolbar.ql-snow .ql-picker-label:hover .ql-stroke,
                .ql-toolbar.ql-snow .ql-picker-item:hover .ql-stroke,
                .ql-toolbar.ql-snow .ql-picker-item.ql-selected .ql-stroke {
                    stroke: #3b82f6;
                }

                .ql-toolbar.ql-snow button:hover .ql-fill,
                .ql-toolbar.ql-snow button:focus .ql-fill,
                .ql-toolbar.ql-snow button.ql-active .ql-fill,
                .ql-toolbar.ql-snow .ql-picker-label:hover .ql-fill,
                .ql-toolbar.ql-snow .ql-picker-item:hover .ql-fill,
                .ql-toolbar.ql-snow .ql-picker-item.ql-selected .ql-fill,
                .ql-toolbar.ql-snow .ql-picker-item.ql-selected .ql-stroke.ql-fill {
                    fill: #3b82f6;
                }

                .ql-picker {
                    color: #64748b;
                }

                .dark .ql-picker {
                    color: #cbd5e1;
                }

                .ql-toolbar.ql-snow .ql-picker-label {
                    border: 1px solid #cbd5e1;
                    border-radius: 4px;
                    padding: 4px 8px;
                }

                .dark .ql-toolbar.ql-snow .ql-picker-label {
                    border-color: #475569;
                }

                .ql-toolbar.ql-snow .ql-picker-options {
                    border: 1px solid #e2e8f0;
                    border-radius: 6px;
                    background: white;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }

                .dark .ql-toolbar.ql-snow .ql-picker-options {
                    background-color: #1e293b;
                    border-color: #334155;
                }

                .ql-toolbar.ql-snow .ql-picker-item {
                    color: #1e293b;
                    padding: 6px 12px;
                }

                .dark .ql-toolbar.ql-snow .ql-picker-item {
                    color: #e2e8f0;
                }

                /* Editor content styling */
                .ql-editor h1,
                .ql-editor h2,
                .ql-editor h3 {
                    margin-top: 12px;
                    margin-bottom: 8px;
                    font-weight: 600;
                    color: #1e293b;
                }

                .dark .ql-editor h1,
                .dark .ql-editor h2,
                .dark .ql-editor h3 {
                    color: #f1f5f9;
                }

                .ql-editor h1 { font-size: 28px; }
                .ql-editor h2 { font-size: 24px; }
                .ql-editor h3 { font-size: 20px; }

                .ql-editor ol,
                .ql-editor ul {
                    padding-left: 24px;
                    margin: 8px 0;
                }

                .ql-editor code {
                    background-color: #f1f5f9;
                    color: #e11d48;
                    padding: 2px 6px;
                    border-radius: 3px;
                    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
                    font-size: 13px;
                }

                .dark .ql-editor code {
                    background-color: #1e293b;
                    color: #f87171;
                }

                .ql-editor blockquote {
                    border-left: 4px solid #3b82f6;
                    margin: 12px 0;
                    padding: 8px 16px;
                    background-color: #eff6ff;
                }

                .dark .ql-editor blockquote {
                    background-color: #0c2d4d;
                }

                .ql-editor pre {
                    background-color: #1e293b;
                    color: #e2e8f0;
                    padding: 12px;
                    border-radius: 6px;
                    overflow-x: auto;
                }

                .ql-editor img {
                    border-radius: 6px;
                    max-width: 100%;
                    height: auto;
                }

                .ql-editor a {
                    color: #3b82f6;
                    text-decoration: underline;
                }

                .dark .ql-editor a {
                    color: #60a5fa;
                }

                .ql-editor a:hover {
                    color: #1d4ed8;
                }

                .dark .ql-editor a:hover {
                    color: #93c5fd;
                }
            </style>

            <!-- Editor Container -->
            <div 
                id="{{ $editorId }}"
                class="bg-white dark:bg-slate-900"
            ></div>
            
            <!-- Hidden Input -->
            <input 
                type="hidden" 
                name="{{ $name }}" 
                id="{{ $idAttr }}"
                value="{{ $oldValue }}"
                @input="charCount = this.value.replace(/<[^>]*>/g, '').trim().length"
            />
        </div>

        <!-- Character Counter (Opsional) -->
        <div class="mt-2 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
            <span>Minimal diperlukan beberapa karakter untuk konten yang bermakna</span>
            <span x-text="`${charCount} karakter`"></span>
        </div>
    </div>
    
    @if($hasError)
        <p class="mt-2 text-sm text-red-500 dark:text-red-400 font-medium">{{ $errors->first($name) }}</p>
    @endif
</div>

@push('styles')
<style>
    #{{ $editorId }} .ql-toolbar {
        @apply bg-slate-50 dark:bg-slate-900 border-b border-slate-300 dark:border-slate-700 rounded-t-lg;
    }
    
    #{{ $editorId }} .ql-container {
        @apply bg-white dark:bg-slate-800 rounded-b-lg;
        min-height: calc({{ $height }} - 42px);
    }
    
    #{{ $editorId }} .ql-editor {
        @apply text-slate-900 dark:text-white;
        min-height: calc({{ $height }} - 42px);
    }
    
    #{{ $editorId }} .ql-editor.ql-blank::before {
        @apply text-slate-500 dark:text-slate-400 italic;
    }
    
    /* Toolbar button styles */
    #{{ $editorId }} .ql-toolbar button {
        @apply text-slate-700 dark:text-slate-300;
    }
    
    #{{ $editorId }} .ql-toolbar button:hover {
        @apply text-blue-600 dark:text-blue-400;
    }
    
    #{{ $editorId }} .ql-toolbar button.ql-active {
        @apply text-blue-600 dark:text-blue-400;
    }
    
    #{{ $editorId }} .ql-toolbar .ql-stroke {
        @apply stroke-current;
    }
    
    #{{ $editorId }} .ql-toolbar .ql-fill {
        @apply fill-current;
    }
    
    #{{ $editorId }} .ql-toolbar .ql-picker-label {
        @apply text-slate-700 dark:text-slate-300;
    }
    
    #{{ $editorId }} .ql-toolbar .ql-picker-options {
        @apply bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700;
    }
    
    #{{ $editorId }} .ql-toolbar .ql-picker-item {
        @apply text-slate-700 dark:text-slate-300;
    }
    
    #{{ $editorId }} .ql-toolbar .ql-picker-item:hover {
        @apply text-blue-600 dark:text-blue-400;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Quill editor
        const toolbarOptions = @json($toolbarConfig);
        
        const quill_{{ Str::slug($editorId, '_') }} = new Quill('#{{ $editorId }}', {
            theme: 'snow',
            placeholder: '{{ $placeholder }}',
            modules: {
                toolbar: toolbarOptions
            }
        });
        
        // Set initial content
        const initialContent = document.getElementById('{{ $idAttr }}').value;
        if (initialContent) {
            quill_{{ Str::slug($editorId, '_') }}.root.innerHTML = initialContent;
        }
        
        // Update hidden input on text change
        quill_{{ Str::slug($editorId, '_') }}.on('text-change', function() {
            const html = quill_{{ Str::slug($editorId, '_') }}.root.innerHTML;
            document.getElementById('{{ $idAttr }}').value = html;
        });
        
        // Validate on form submit if required
        @if($required)
        const form = document.getElementById('{{ $idAttr }}').closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const content = quill_{{ Str::slug($editorId, '_') }}.getText().trim();
                if (!content) {
                    e.preventDefault();
                    alert('{{ $label ?? 'Field ini' }} wajib diisi');
                    quill_{{ Str::slug($editorId, '_') }}.focus();
                }
            });
        }
        @endif
    });
</script>
@endpush