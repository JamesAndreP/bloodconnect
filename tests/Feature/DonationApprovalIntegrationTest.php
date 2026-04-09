<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Hospital;
use App\Models\DonationRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DonationApprovalIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function hospital_can_approve_request_and_donor_can_see_updated_status()
    {
        // STEP 1: Create hospital user
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

        // STEP 2: Create hospital
        $hospital = Hospital::create([
            'user_id' => $hospitalUser->id,
            'name' => 'Test Hospital',
            'location' => 'Philippines|Cebu|Mandaue City',
        ]);

        // STEP 3: Create donor
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

        // STEP 4: Create donation request manually
        $request = DonationRequest::create([
            'user_id' => $donor->id,
            'hospital_id' => $hospital->id,
            'date' => now(),
            'status' => 'Pending',
        ]);

        // STEP 5: Hospital login
        $this->actingAs($hospitalUser);

        // STEP 6: Approve request
        $response = $this->patch(route('donation-requests.approve', $request->id), [
            'date' => now()->addDays(1)->toDateString(),
            'notes' => 'Approved schedule',
        ]);

        $response->assertStatus(302);

        // STEP 7: Check database updated
        $this->assertDatabaseHas('donation_requests', [
            'id' => $request->id,
            'status' => 'Approved',
        ]);

        // STEP 8: Donor login
        $this->actingAs($donor);

        // STEP 9: Donor checks the specific request details
        $response = $this->get(route('donation-requests.show', $request->id));

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $request->id,
            'status' => 'Approved',
        ]);
    }
}