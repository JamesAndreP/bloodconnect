<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Hospital;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DonationRequestIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function donor_can_create_request_and_hospital_can_view_it()
    {
        // STEP 1: Create hospital user manually
        $hospitalUser = User::create([
            'name' => 'Hospital User',
            'email' => 'hospital@example.com',
            'password' => Hash::make('password123'),
            'role' => 'hospital',
            'status' => 'Active',
            'location' => 'Philippines|Cebu|Mandaue City',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
            'phone' => '09111111111',
            'email_verified_at' => now(),
        ]);

        // STEP 2: Create hospital manually
        $hospital = Hospital::create([
            'user_id' => $hospitalUser->id,
            'name' => 'Test Hospital',
            'location' => 'Mandaue City',
        ]);

        // STEP 3: Create donor manually
        $donor = User::create([
            'name' => 'Donor User',
            'email' => 'donor@example.com',
            'password' => Hash::make('password123'),
            'role' => 'donor',
            'status' => 'Active',
            'location' => 'Philippines|Cebu|Mandaue City',
            'birth_date' => '2000-01-01',
            'gender' => 'male',
            'phone' => '09222222222',
            'email_verified_at' => now(),
        ]);

        // STEP 4: Donor login
        $this->actingAs($donor);

        // STEP 5: Donor creates donation request
        $response = $this->post(route('donation-requests.store'), [
            'hospital_id' => $hospital->id,
            'notes' => 'Test donation request',
        ]);

        $response->assertStatus(302);

        // STEP 6: Confirm request exists in database
        $this->assertDatabaseHas('donation_requests', [
            'user_id' => $donor->id,
            'hospital_id' => $hospital->id,
        ]);

        // STEP 7: Hospital login
        $this->actingAs($hospitalUser);

        // STEP 8: Hospital views requests
        $response = $this->get(route('donation-requests.hospital'));

        $response->assertStatus(200);
        $response->assertSee('Donor User');
        $response->assertSee('donor@example.com');
        $response->assertSee('Pending');
    }
}