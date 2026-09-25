<?php

namespace App\Livewire\Hotel;

use App\Models\HotelGuest;
use App\Models\MainSiteData;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class GuestManager extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 12;
    public bool $showForm = false;
    public ?int $guestId = null;

    public array $form = [];

    public function mount(): void
    {
        if (! hasAccess(['Super Admin', 'Hotel User'], ['hotel-view-guests'])) {
            abort(403, 'Hotel module access is required.');
        }

        $this->resetForm();
    }

    public function newGuest(): void
    {
        if (abortIfNoAccess(['Super Admin', 'Hotel User'], ['hotel-create-guest'], 'You do not have permission to register hotel guests.')) {
            return;
        }

        $this->guestId = null;
        $this->resetForm();
        $this->form['check_in'] = now()->format('Y-m-d\TH:i');
        $this->showForm = true;
    }

    public function editGuest(int $guestId): void
    {
        if (abortIfNoAccess(['Super Admin', 'Hotel User'], ['hotel-edit-guest'], 'You do not have permission to edit hotel guests.')) {
            return;
        }

        $guest = HotelGuest::findOrFail($guestId);
        $this->guestId = $guest->id;
        $this->form = [
            'guest_name' => $guest->guest_name,
            'gender' => $guest->gender,
            'nationality' => $guest->nationality,
            'document_type' => $guest->document_type,
            'document_number' => $guest->document_number,
            'phone' => $guest->phone,
            'email' => $guest->email,
            'address' => $guest->address,
            'room_number' => $guest->room_number,
            'check_in' => optional($guest->check_in)->format('Y-m-d\TH:i'),
            'check_out' => optional($guest->check_out)->format('Y-m-d\TH:i'),
            'adults' => $guest->adults,
            'children' => $guest->children,
            'purpose' => $guest->purpose,
            'notes' => $guest->notes,
        ];
        $this->showForm = true;
    }

    public function saveGuest(): void
    {
        $permission = $this->guestId ? 'hotel-edit-guest' : 'hotel-create-guest';
        if (abortIfNoAccess(['Super Admin', 'Hotel User'], [$permission], 'You do not have permission to save hotel guests.')) {
            return;
        }

        $this->validate([
            'form.guest_name' => ['required', 'string', 'max:255'],
            'form.gender' => ['nullable', Rule::in(['Male', 'Female', 'Other'])],
            'form.nationality' => ['nullable', 'string', 'max:100'],
            'form.document_type' => ['nullable', Rule::in(['National ID', 'Passport', 'Driving Licence', 'Other'])],
            'form.document_number' => ['nullable', 'string', 'max:100'],
            'form.phone' => ['nullable', 'string', 'max:50'],
            'form.email' => ['nullable', 'email', 'max:255'],
            'form.address' => ['nullable', 'string', 'max:1000'],
            'form.room_number' => ['nullable', 'string', 'max:50'],
            'form.check_in' => ['required', 'date'],
            'form.check_out' => ['nullable', 'date', 'after_or_equal:form.check_in'],
            'form.adults' => ['required', 'integer', 'min:1', 'max:50'],
            'form.children' => ['required', 'integer', 'min:0', 'max:50'],
            'form.purpose' => ['nullable', 'string', 'max:255'],
            'form.notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $wasCreating = ! $this->guestId;
        $guest = $this->guestId ? HotelGuest::findOrFail($this->guestId) : new HotelGuest();
        if (! $guest->exists) {
            $prefix = trim((string) MainSiteData::getValue('hotel_voucher_prefix', 'HTL-'));
            $guest->voucher_number = $prefix.Carbon::now()->format('YmdHis').'-'.str()->upper(str()->random(4));
            $guest->registered_by = auth()->id();
        }

        $guest->fill([
            ...$this->form,
            'check_in' => Carbon::parse($this->form['check_in']),
            'check_out' => filled($this->form['check_out'] ?? null) ? Carbon::parse($this->form['check_out']) : null,
            'registered_by' => $guest->registered_by ?: auth()->id(),
        ]);
        $guest->save();

        $this->guestId = $guest->id;
        $this->showForm = false;
        $this->resetForm();
        flash()->success($wasCreating ? 'Hotel guest registered successfully.' : 'Hotel guest record updated successfully.');
    }

    public function deleteGuest(int $guestId): void
    {
        if (abortIfNoAccess(['Super Admin', 'Hotel User'], ['hotel-delete-guest'], 'You do not have permission to delete hotel guests.')) {
            return;
        }

        HotelGuest::findOrFail($guestId)->delete();
        flash()->success('Hotel guest record deleted.');
    }

    public function resetForm(): void
    {
        $this->form = [
            'guest_name' => '',
            'gender' => '',
            'nationality' => '',
            'document_type' => '',
            'document_number' => '',
            'phone' => '',
            'email' => '',
            'address' => '',
            'room_number' => '',
            'check_in' => now()->format('Y-m-d\TH:i'),
            'check_out' => '',
            'adults' => 1,
            'children' => 0,
            'purpose' => '',
            'notes' => '',
        ];
    }

    public function render()
    {
        $guests = HotelGuest::query()
            ->with('registrar')
            ->when($this->search !== '', function ($query) {
                $term = '%'.$this->search.'%';
                $query->where(function ($q) use ($term) {
                    $q->where('guest_name', 'like', $term)
                        ->orWhere('voucher_number', 'like', $term)
                        ->orWhere('document_number', 'like', $term)
                        ->orWhere('room_number', 'like', $term)
                        ->orWhere('phone', 'like', $term);
                });
            })
            ->latest('check_in')
            ->paginate($this->perPage);

        return view('livewire.hotel.guest-manager', [
            'guests' => $guests,
            'hotelName' => MainSiteData::getValue('hotel_name', siteUrlSettings('site_name') ?: config('app.name')),
        ])->layout('layouts.app');
    }
}
