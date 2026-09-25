@if (file_exists(public_path('images/skytech-infranet-logo.png')))
    <img src="{{ asset('images/skytech-infranet-logo.png') }}" alt="Picture" class="auth-logo">
@else
    <h2 class="box__title neon-text audiowide-bold">{{ env('APP_NAME') }}</h2>
@endif