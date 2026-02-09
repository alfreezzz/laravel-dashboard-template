{{--
    Component: footer
    Usage: <x-footer />
    Props: none
--}}
<footer class="mt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-4 border-t border-slate-200 dark:border-slate-800">
            <div class="text-sm text-slate-600 dark:text-slate-400 text-center">
                &copy; {{ now()->year }} {{ env('APP_NAME') }}. All rights reserved.
            </div>
        </div>
    </div>
</footer>
