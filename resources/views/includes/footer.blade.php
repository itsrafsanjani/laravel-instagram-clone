<footer class="footer bg-glass mt-auto py-2">
    <div class="container">
        <div class="d-md-flex text-center justify-content-between">
            <div class="text-muted">
                &#169; <a href="{{ config('app.url') }}" target="_blank">{{ __(config('app.name')) }}</a>
            </div>
            <div class="text-muted">
                <a href="{{ route('static-pages.privacy-policy') }}" target="_blank" class="ml-2">
                    {{ __('Privacy Policy') }}
                </a>
                <a href="{{ route('static-pages.terms-of-service') }}" target="_blank" class="ml-2">
                    {{ __('Terms of Service') }}
                </a>
                <a href="{{ route('static-pages.cookies') }}" target="_blank" class="ml-2">
                    {{ __('Cookies') }}
                </a>
            </div>
        </div>
    </div>
</footer>
