    <!-- <img {{ $attributes }} class="w-100" src="{{ asset('img/logo.png') }}" alt=""> -->
    <!-- <h3 class="text-center">{{ env('APP_NAME') }}</h3>  -->

@if (siteUrlSettings('site_logo'))
    <img class="me-2" style="width: 190px; height: 53px;" src="{{ site_image(siteUrlSettings('site_logo')) }}" alt="logo"/>
@else
    @if (siteUrlSettings('site_icon'))
        <img class="me-2" src="{{ site_image(siteUrlSettings('site_icon')) }}" alt="" width="40" />
        <span class="font-sans-serif text-success d-block">{{ siteUrlSettings('site_name') ?? 'SONGOROKA SKYTECH INFRANET' }}</span>
        <small class="d-block text-muted fw-semibold">ISP Billing</small>
    @else
        <span class="font-sans-serif text-success d-block">{{ siteUrlSettings('site_name') ?? 'SONGOROKA SKYTECH INFRANET' }}</span>
        <small class="d-block text-muted fw-semibold">ISP Billing</small>
    @endif
@endif
