{{--
    Component: page-header
    Usage: <x-page-header title="Daftar Barang" subtitle="Kelola stok" actionLabel="Tambah" actionUrl="{{ route('items.create') }}" />
    Props:
        - title (required): string - main title text.
        - subtitle (optional): string - smaller subtitle under the title.
        - actionLabel (optional): string - label for the action button.
        - actionUrl (optional): string - URL for the action button.
    Notes:
        - The action button is only shown if both actionLabel and actionUrl are provided.
--}}
@props(['title', 'subtitle' => null, 'actionLabel' => null, 'actionUrl' => null])

<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $title }}</h1>
            @if($subtitle)
                <p class="text-slate-600 dark:text-slate-400 mt-1">{{ $subtitle }}</p>
            @endif
        </div>
        @if($actionUrl && $actionLabel)
            <a href="{{ $actionUrl }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white rounded-lg transition font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                {{ $actionLabel }}
            </a>
        @endif
    </div>
</div>
