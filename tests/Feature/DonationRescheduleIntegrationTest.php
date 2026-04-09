<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Hospital;
use App\Models\DonationRequest;
use App\Models\DonationRequestSchedule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DonationRescheduleIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function donor_can_submit_reschedule_request()
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

        // STEP 4: Create approved donation request
        $request = DonationRequest::create([
            'user_id' => $donor->id,
            'hospital_id' => $hospital->id,
            'notes' => 'Initial request',
            'status' => 'Approved',
        ]);

        // STEP 5: Create active schedule first
        DonationRequestSchedule::create([
            'donation_request_id' => $request->id,
            'date' => now()->addDays(1)->toDateString(),
            'notes' => 'Original approved schedule',
            'status' => 'Active',
        ]);

        // STEP 6: Donor login
        $this->actingAs($donor);

        // STEP 7: Submit reschedule request
        $response = $this->patch(route('donation-requests.reschedule', $request->id), [
            'date' => now()->addDays(3)->toDateString(),
            'notes' => 'Need to reschedule',
        ]);

        $response->assertStatus(302);

        // STEP 8: Donation request should now be marked as reschedule request
        $this->assertDatabaseHas('donation_requests', [
            'id' => $request->id,
            'status' => 'RescheduleRequest',
        ]);

        // STEP 9: Pending reschedule schedule should exist
        $this->assertDatabaseHas('donation_request_schedules', [
            'donation_request_id' => $request->id,
            'notes' => 'Need to reschedule',
            'status' => 'Pending',
        ]);
    }
}