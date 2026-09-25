<div class="row g-4">

    {{-- ============================================================
         HOTSPOT VOUCHER GENERATOR
    ============================================================= --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-wifi text-primary me-2"></i>
                    {{ __('Generate Hotspot Vouchers') }}
                </h5>

                <small class="text-muted">
                    {{ __('Generate vouchers from your assigned hotspot packages.') }}
                </small>
            </div>

            <div class="card-body">

                <form wire:submit="generate">

                    {{-- Package --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            {{ __('Hotspot Package') }}
                        </label>

                        <select
                            wire:model.live="package_id"
                            class="form-select"
                            required
                        >
                            <option value="">
                                {{ __('-- Select Hotspot Package --') }}
                            </option>

                            @foreach($packages as $pkg)
                                <option value="{{ $pkg->id }}">
                                    {{ $pkg->package }}
                                    — TZS {{ number_format((float) $pkg->price, 0) }}
                                    @if($pkg->router_name)
                                        — {{ $pkg->router_name }}
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        <small class="text-muted d-block mt-1">
                            {{ __('Only packages assigned to your reseller account are available.') }}
                        </small>

                        @error('package_id')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Selected Package Information --}}
                    @if($package_id)
                        @php
                            $selectedPackage = $packages->firstWhere('id', (int) $package_id);
                        @endphp

                        @if($selectedPackage)
                            <div class="alert alert-primary border-0 rounded-3 py-2 px-3 mb-3">

                                <div class="fw-bold">
                                    {{ $selectedPackage->package }}
                                </div>

                                <div class="small">
                                    <strong>{{ __('Price:') }}</strong>
                                    TZS {{ number_format((float) $selectedPackage->price, 2) }}
                                </div>

                                <div class="small">
                                    <strong>{{ __('Router:') }}</strong>
                                    {{ $selectedPackage->router_name ?: __('Not linked') }}
                                </div>

                                <div class="small">
                                    <strong>{{ __('MikroTik Profile:') }}</strong>
                                    {{ $selectedPackage->package }}
                                </div>

                                @if($selectedPackage->speed)
                                    <div class="small">
                                        <strong>{{ __('Speed:') }}</strong>
                                        {{ $selectedPackage->speed }}
                                    </div>
                                @endif

                            </div>
                        @endif
                    @endif

                    {{-- Number --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            {{ __('Number of Vouchers') }}
                        </label>

                        <input
                            type="number"
                            wire:model="count"
                            class="form-control"
                            min="1"
                            max="500"
                            required
                        >

                        <small class="text-muted">
                            {{ __('Generate up to 500 vouchers in one batch.') }}
                        </small>

                        @error('count')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Code Length --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            {{ __('Voucher Code Length') }}
                        </label>

                        <input
                            type="number"
                            wire:model="length"
                            class="form-control"
                            min="3"
                            max="20"
                            required
                        >

                        @error('length')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Prefix --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            {{ __('Prefix') }}
                        </label>

                        <input
                            type="text"
                            wire:model="prefix"
                            class="form-control"
                            maxlength="20"
                            placeholder="HOT-"
                        >

                        <small class="text-muted">
                            {{ __('Optional prefix for voucher codes.') }}
                        </small>

                        @error('prefix')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-check mb-3">
                        <input
                            type="checkbox"
                            wire:model="user_equals_password"
                            class="form-check-input"
                            id="user_equals_password"
                        >

                        <label
                            class="form-check-label fw-semibold"
                            for="user_equals_password"
                        >
                            {{ __('Username and password are the same') }}
                        </label>
                    </div>

                    {{-- Validity Type --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            {{ __('Validity Type') }}
                        </label>

                        <select
                            wire:model.live="validity_type"
                            class="form-select"
                            required
                        >
                            <option value="uptime">
                                {{ __('Uptime Limit') }}
                            </option>

                            <option value="realtime">
                                {{ __('Real-time Validity') }}
                            </option>
                        </select>

                        @error('validity_type')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Uptime --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            {{ $validity_type === 'realtime'
                                ? __('Validity Duration')
                                : __('Uptime Limit') }}
                        </label>

                        <input
                            type="text"
                            wire:model="limit_uptime"
                            class="form-control"
                            placeholder="1h / 6h / 1d / 1d12h"
                        >

                        <small class="text-muted">
                            {{ __('Example: 30m, 1h, 6h, 1d, 7d.') }}
                        </small>

                        @error('limit_uptime')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Expiry --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            {{ __('Voucher Expiry Date') }}
                        </label>

                        <input
                            type="date"
                            wire:model="expiry_date"
                            class="form-control"
                            min="{{ now()->addDay()->format('Y-m-d') }}"
                            required
                        >

                        <small class="text-muted">
                            {{ __('The voucher inventory expires at the end of this day.') }}
                        </small>

                        @error('expiry_date')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Batch --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            {{ __('Batch Name') }}
                        </label>

                        <input
                            type="text"
                            wire:model="batch_name"
                            class="form-control"
                            maxlength="100"
                            placeholder="Leave blank for automatic name"
                        >

                        @error('batch_name')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Push --}}
                    <div class="form-check mb-3">
                        <input
                            type="checkbox"
                            wire:model="push_to_router"
                            class="form-check-input"
                            id="push_to_router"
                        >

                        <label
                            class="form-check-label fw-semibold"
                            for="push_to_router"
                        >
                            <i class="bi bi-router me-1"></i>
                            {{ __('Push vouchers to MikroTik automatically') }}
                        </label>
                    </div>

                    {{-- Cost Preview --}}
                    @if($package_id && $selectedPackage)
                        @php
                            $voucherPrice = (float) $selectedPackage->price;
                            $commission = (float) $reseller->commission_percentage;
                            $discounted = (bool) $reseller->getSetting('pay_discounted_upfront', false);
                            $unitCost = $discounted
                                ? $voucherPrice * (1 - ($commission / 100))
                                : $voucherPrice;
                            $totalCost = $unitCost * (int) $count;
                        @endphp

                        <div class="alert alert-light border rounded-3 mb-3">

                            <div class="d-flex justify-content-between small mb-1">
                                <span>{{ __('Voucher Price') }}</span>
                                <strong>
                                    TZS {{ number_format($voucherPrice, 2) }}
                                </strong>
                            </div>

                            @if($discounted)
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>{{ __('Commission Discount') }}</span>
                                    <strong>
                                        {{ number_format($commission, 2) }}%
                                    </strong>
                                </div>
                            @endif

                            <hr class="my-2">

                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">
                                    {{ __('Estimated Wallet Cost') }}
                                </span>

                                <strong class="text-danger">
                                    TZS {{ number_format($totalCost, 2) }}
                                </strong>
                            </div>

                            <div class="small text-muted mt-1">
                                {{ __('Wallet Balance:') }}
                                TZS {{ number_format((float) $reseller->balance, 2) }}
                            </div>

                        </div>
                    @endif

                    {{-- Generate --}}
                    <div class="d-grid mt-4">

                        <button
                            type="submit"
                            class="btn btn-success rounded-3 fw-bold"
                            wire:loading.attr="disabled"
                            wire:target="generate"
                        >
                            <span wire:loading.remove wire:target="generate">
                                <i class="bi bi-ticket-perforated me-1"></i>
                                {{ __('Generate Hotspot Vouchers') }}
                            </span>

                            <span wire:loading wire:target="generate">
                                <span class="spinner-border spinner-border-sm me-1"></span>
                                {{ __('Generating...') }}
                            </span>
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>


    {{-- ============================================================
         VOUCHER LIST
    ============================================================= --}}
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white border-0 py-3">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

                    <div>
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-ticket-perforated-fill text-primary me-2"></i>
                            {{ __('My Hotspot Vouchers') }}
                        </h5>

                        <small class="text-muted">
                            {{ __('Vouchers generated by your reseller account.') }}
                        </small>
                    </div>

                    <div style="min-width: 220px;">
                        <input
                            type="search"
                            wire:model.live.debounce.400ms="voucherSearch"
                            class="form-control form-control-sm"
                            placeholder="{{ __('Search voucher...') }}"
                        >
                    </div>

                </div>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th class="ps-3">{{ __('Voucher') }}</th>
                                <th>{{ __('Package / Profile') }}</th>
                                <th>{{ __('Router') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Batch') }}</th>
                                <th class="text-center">{{ __('Status') }}</th>
                                <th class="text-center">{{ __('Expires') }}</th>
                                <th class="text-end pe-3">{{ __('Action') }}</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($vouchers as $voucher)

                                <tr>

                                    {{-- Code --}}
                                    <td class="ps-3">

                                        <div class="fw-bold text-dark">
                                            <code>{{ $voucher->code }}</code>
                                        </div>

                                        @if($voucher->username)
                                            <small class="text-muted">
                                                {{ __('User:') }}
                                                {{ $voucher->username }}
                                            </small>
                                        @endif

                                    </td>

                                    {{-- Profile --}}
                                    <td>

                                        <span class="badge bg-primary-subtle text-primary">
                                            {{ $voucher->profile }}
                                        </span>

                                        @if($voucher->validity_duration)
                                            <div class="small text-muted mt-1">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $voucher->validity_duration }}
                                            </div>
                                        @endif

                                    </td>

                                    {{-- Router --}}
                                    <td class="small">
                                        <i class="bi bi-router me-1"></i>
                                        {{ $voucher->router_name }}
                                    </td>

                                    {{-- Price --}}
                                    <td class="fw-semibold text-success">
                                        TZS {{ number_format((float) $voucher->price, 2) }}
                                    </td>

                                    {{-- Batch --}}
                                    <td class="small">
                                        {{ $voucher->batch_name ?: '-' }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="text-center">

                                        @if($voucher->status === 'unused')

                                            @if($voucher->expires_at && $voucher->expires_at->isPast())

                                                <span class="badge bg-danger-subtle text-danger">
                                                    {{ __('Expired') }}
                                                </span>

                                            @else

                                                <span class="badge bg-success-subtle text-success">
                                                    {{ __('Unused') }}
                                                </span>

                                            @endif

                                        @elseif($voucher->status === 'used')

                                            <span class="badge bg-secondary-subtle text-secondary">
                                                {{ __('Used') }}
                                            </span>

                                        @else

                                            <span class="badge bg-warning-subtle text-warning">
                                                {{ ucfirst($voucher->status) }}
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Expiry --}}
                                    <td class="text-center small">

                                        @if($voucher->expires_at)
                                            {{ $voucher->expires_at->format('Y-m-d') }}

                                            <div class="text-muted">
                                                {{ $voucher->expires_at->format('H:i') }}
                                            </div>
                                        @else
                                            -
                                        @endif

                                    </td>

                                    {{-- Action --}}
                                    <td class="text-end pe-3">

                                        @if(
                                            $voucher->status === 'unused'
                                            && (
                                                ! $voucher->expires_at
                                                || ! $voucher->expires_at->isPast()
                                            )
                                        )

                                            <button
                                                type="button"
                                                onclick="if(!confirm('{{ __('Are you sure you want to cancel this voucher and refund TZS :value to your wallet?', ['value' => number_format((float) $voucher->price, 2)]) }}')) { event.stopImmediatePropagation(); return false; }"
                                                wire:click="cancelVoucher({{ $voucher->id }})"
                                                class="btn btn-outline-danger btn-sm rounded-pill px-2"
                                                wire:loading.attr="disabled"
                                                wire:target="cancelVoucher({{ $voucher->id }})"
                                            >
                                                <i class="bi bi-x-circle me-1"></i>
                                                {{ __('Cancel') }}
                                            </button>

                                        @else

                                            <span class="text-muted small">-</span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="text-center text-muted py-5"
                                    >
                                        <i class="bi bi-ticket-perforated fs-2 d-block mb-2"></i>

                                        {{ __('No hotspot vouchers generated yet.') }}

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                @if($vouchers->hasPages())

                    <div class="card-footer bg-white border-0 py-3">
                        {{ $vouchers->links() }}
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>
