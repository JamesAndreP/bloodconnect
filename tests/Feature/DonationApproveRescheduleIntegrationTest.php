<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Hospital;
use App\Models\DonationRequest;
use App\Models\DonationRequestSchedule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DonationApproveRescheduleIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function hospital_can_approve_reschedule_request()
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

        // STEP 4: Create donation request already under reschedule state
        $request = DonationRequest::create([
            'user_id' => $donor->id,
            'hospital_id' => $hospital->id,
            'notes' => 'Initial request',
            'status' => 'RescheduleRequest',
        ]);

        // STEP 5: Old active schedule
        $oldSchedule = DonationRequestSchedule::create([
            'donation_request_id' => $request->id,
            'date' => now()->addDays(1)->toDateString(),
            'notes' => 'Original approved schedule',
            'status' => 'Active',
        ]);

        // STEP 6: Pending reschedule request
        $pendingReschedule = DonationRequestSchedule::create([
            'donation_request_id' => $request->id,
            'date' => now()->addDays(3)->toDateString(),
            'notes' => 'Requested new schedule',
            'status' => 'Pending',
        ]);

        // STEP 7: Hospital login
        $this->actingAs($hospitalUser);

        // STEP 8: Approve the pending reschedule
        $response = $this->patch(route('donation-requests.reschedule.approve', $pendingReschedule->id));

        $response->assertStatus(302);

        // STEP 9: Donation request should return to Approved
        $this->assertDatabaseHas('donation_requests', [
            'id' => $request->id,
            'status' => 'Approved',
        ]);

        // STEP 10: Old schedule should now be inactive
        $this->assertDatabaseHas('donation_request_schedules', [
            'id' => $oldSchedule->id,
            'status' => 'Inactive',
        ]);

        // STEP 11: Pending reschedule should now be active
        $this->assertDatabaseHas('donation_request_schedules', [
            'id' => $pendingReschedule->id,
            'status' => 'Active',
        ]);
    }
}