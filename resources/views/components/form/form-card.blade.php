{{--
    Component: form-card
    Usage: <x-form.form-card title="Tambah Barang" :backUrl="route('items.index')">...form...</x-form.form-card>
    Props:
        - title (required): string - page/title text shown above the card.
        - backUrl (optional): string - URL for a back button (if provided, a back button will be shown).
--}}
@props(['title', 'backUrl' => null])

<div class="mb-8">
    <div class="flex items-center gap-3">
        @if($backUrl)
            <a href="{{ $backUrl }}" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition">
                <svg class="w-6 h-6 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
        @endif
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $title }}</h1>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-slate-200 dark:border-slate-700 p-6">
    {{ $slot }}
</div>
