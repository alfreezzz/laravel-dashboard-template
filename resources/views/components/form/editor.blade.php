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

<div class="mb-4">
    @if($label)
        <label for="{{ $idAttr }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div class="editor-wrapper">
        <!-- Editor Container -->
        <div 
            id="{{ $editorId }}"
            class="bg-white dark:bg-slate-800 rounded-lg border {{ $hasError ? 'border-red-500 dark:border-red-500' : 'border-slate-300 dark:border-slate-700' }} focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent transition"
            style="min-height: {{ $height }}"
        ></div>
        
        <!-- Hidden Input -->
        <input 
            type="hidden" 
            name="{{ $name }}" 
            id="{{ $idAttr }}"
            value="{{ $oldValue }}"
        />
    </div>
    
    @if($hasError)
        <p class="mt-1 text-sm text-red-500 dark:text-red-400">{{ $errors->first($name) }}</p>
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