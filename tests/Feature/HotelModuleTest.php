<?php

namespace Tests\Feature;

use App\Models\HotelGuest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class HotelModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'Hotel User', 'guard_name' => 'web']);
        foreach ([
            'hotel-view-guests',
            'hotel-create-guest',
            'hotel-edit-guest',
            'hotel-delete-guest',
            'hotel-print-voucher',
        ] as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
        Role::findByName('Hotel User')->syncPermissions(Permission::where('name', 'like', 'hotel-%')->get());
    }

    public function test_hotel_user_can_access_hotel_workspace(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Hotel User');

        $this->actingAs($user)
            ->get('/hotel/guests')
            ->assertOk();
    }

    public function test_hotel_user_is_redirected_away_from_billing_routes(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Hotel User');

        $this->actingAs($user)
            ->get('/payment-collection')
            ->assertRedirect('/hotel/guests');
    }

    public function test_hotel_guest_can_be_created_without_billing_fields(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Hotel User');

        $guest = HotelGuest::create([
            'voucher_number' => 'HTL-TEST-001',
            'guest_name' => 'Test Guest',
            'check_in' => now(),
            'adults' => 1,
            'children' => 0,
            'registered_by' => $user->id,
        ]);

        $this->assertDatabaseHas('hotel_guests', [
            'id' => $guest->id,
            'voucher_number' => 'HTL-TEST-001',
            'guest_name' => 'Test Guest',
        ]);
    }
}
