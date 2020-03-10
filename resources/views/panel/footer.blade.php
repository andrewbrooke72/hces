<footer class="app-footer">
    <span><a href="/" class="text-arsenal-blue">{{ env('APP_NAME') }}</a> © {{ env('YEAR_STARTED') }} - {{ \Carbon\Carbon::now()->year }} Iris Global.</span>
    <span class="ml-auto">PHP {{ phpversion() }}</span>
</footer>
