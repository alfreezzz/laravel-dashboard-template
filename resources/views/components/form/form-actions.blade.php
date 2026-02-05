{{--
    Component: form-actions
    Usage: <x-form.form-actions submitLabel="Simpan" :cancelUrl="route('items.index')" />
    Props:
        - submitLabel (optional): string - label for submit button (default: 'Simpan').
        - cancelUrl (optional): string - if provided, a cancel link will be rendered.
        - cancelLabel (optional): string - label for cancel link (default: 'Batal').
--}}
@props(['submitLabel' => 'Simpan', 'cancelUrl' => null, 'cancelLabel' => 'Batal'])

<div class="flex gap-3 pt-4">
    <x-form.button type="submit" variant="primary">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        {{ $submitLabel }}
    </x-form.button>
    @if($cancelUrl)
        <a href="{{ $cancelUrl }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-900 dark:text-white rounded-lg transition font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            {{ $cancelLabel }}
        </a>
    @endif
</div>
