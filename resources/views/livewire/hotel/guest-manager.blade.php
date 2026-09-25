<div>
    <x-slot name="header">{{ __('Hotel Guest Registration') }}</x-slot>

    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="border-top:4px solid {{ siteUrlSettings('theme_primary_color') ?? '#006DB6' }} !important;">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-3 text-white" style="width:42px;height:42px;background:{{ siteUrlSettings('theme_primary_color') ?? '#006DB6' }};">
                            <i class="bi bi-building fs-5"></i>
                        </span>
                        <div>
                            <h4 class="mb-0 fw-bold">{{ $hotelName }}</h4>
                            <small class="text-muted">{{ __('Guest registration and voucher printing only — no billing.') }}</small>
                        </div>
                    </div>
                </div>
                @can('hotel-create-guest')
                    <button type="button" wire:click="newGuest" class="btn btn-primary rounded-3 px-4">
                        <i class="bi bi-person-plus-fill me-1"></i>{{ __('Register Guest') }}
                    </button>
                @endcan
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="row g-2 mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control" wire:model.live.debounce.300ms="search" placeholder="{{ __('Search guest, voucher, document, room or phone...') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select" wire:model.live="perPage">
                        <option value="12">12 {{ __('per page') }}</option>
                        <option value="24">24 {{ __('per page') }}</option>
                        <option value="48">48 {{ __('per page') }}</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Voucher') }}</th>
                            <th>{{ __('Guest') }}</th>
                            <th>{{ __('Room') }}</th>
                            <th>{{ __('Stay') }}</th>
                            <th>{{ __('Registered By') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guests as $guest)
                            <tr>
                                <td><span class="badge rounded-pill text-bg-primary">{{ $guest->voucher_number }}</span></td>
                                <td>
                                    <div class="fw-semibold">{{ $guest->guest_name }}</div>
                                    <small class="text-muted">{{ $guest->nationality ?: __('Nationality not provided') }} · {{ $guest->phone ?: __('No phone') }}</small>
                                </td>
                                <td>{{ $guest->room_number ?: '—' }}</td>
                                <td>
                                    <div>{{ optional($guest->check_in)->format('d M Y H:i') }}</div>
                                    <small class="text-muted">{{ $guest->check_out ? $guest->check_out->format('d M Y H:i') : __('Open stay') }}</small>
                                </td>
                                <td>{{ $guest->registrar?->name ?: '—' }}</td>
                                <td class="text-end">
                                    @can('hotel-print-voucher')
                                        <a href="{{ route('hotel.guests.print', $guest) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-3" title="{{ __('Print voucher') }}">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    @endcan
                                    @can('hotel-edit-guest')
                                        <button type="button" wire:click="editGuest({{ $guest->id }})" class="btn btn-sm btn-outline-secondary rounded-3">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    @endcan
                                    @can('hotel-delete-guest')
                                        <button type="button" wire:click="deleteGuest({{ $guest->id }})" class="btn btn-sm btn-outline-danger rounded-3" onclick="return confirm('{{ __('Delete this guest record?') }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2"></i>
                                    {{ __('No hotel guest records found.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $guests->links() }}</div>
        </div>
    </div>

    <x-dialog-modal wire:model.live="showForm" maxWidth="4xl">
        <x-slot name="title">
            {{ $guestId ? __('Edit Guest Registration') : __('Register Hotel Guest') }}
        </x-slot>

        <x-slot name="content">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">{{ __('Guest Full Name') }} *</label>
                    <input type="text" class="form-control" wire:model="form.guest_name">
                    @error('form.guest_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">{{ __('Gender') }}</label>
                    <select class="form-select" wire:model="form.gender">
                        <option value="">{{ __('Select') }}</option><option>Male</option><option>Female</option><option>Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">{{ __('Nationality') }}</label>
                    <input type="text" class="form-control" wire:model="form.nationality">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">{{ __('Document Type') }}</label>
                    <select class="form-select" wire:model="form.document_type">
                        <option value="">{{ __('Select') }}</option><option>National ID</option><option>Passport</option><option>Driving Licence</option><option>Other</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">{{ __('Document Number') }}</label>
                    <input type="text" class="form-control" wire:model="form.document_number">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('Phone') }}</label>
                    <input type="text" class="form-control" wire:model="form.phone">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('Email') }}</label>
                    <input type="email" class="form-control" wire:model="form.email">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">{{ __('Address') }}</label>
                    <textarea class="form-control" rows="2" wire:model="form.address"></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">{{ __('Room Number') }}</label>
                    <input type="text" class="form-control" wire:model="form.room_number">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">{{ __('Check In') }} *</label>
                    <input type="datetime-local" class="form-control" wire:model="form.check_in">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">{{ __('Check Out') }}</label>
                    <input type="datetime-local" class="form-control" wire:model="form.check_out">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">{{ __('Adults') }}</label>
                    <input type="number" min="1" class="form-control" wire:model="form.adults">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">{{ __('Children') }}</label>
                    <input type="number" min="0" class="form-control" wire:model="form.children">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{ __('Purpose of Stay') }}</label>
                    <input type="text" class="form-control" wire:model="form.purpose">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">{{ __('Notes') }}</label>
                    <textarea class="form-control" rows="3" wire:model="form.notes"></textarea>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button type="button" class="btn btn-light rounded-3" wire:click="$set('showForm', false)">{{ __('Cancel') }}</button>
            <button type="button" class="btn btn-primary rounded-3" wire:click="saveGuest" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="saveGuest"><i class="bi bi-check2-circle me-1"></i>{{ __('Save Guest') }}</span>
                <span wire:loading wire:target="saveGuest"><span class="spinner-border spinner-border-sm me-1"></span>{{ __('Saving...') }}</span>
            </button>
        </x-slot>
    </x-dialog-modal>
</div>
