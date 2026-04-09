<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Hospital;
use App\Models\BloodRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BloodRequestIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function hospital_can_create_blood_request_and_another_hospital_can_fulfill_it()
    {
        // STEP 1: Create Hospital A user
        $hospitalUserA = User::create([
            'name' => 'Hospital A User',
            'email' => 'hospitala@example.com',
            'password' => Hash::make('password123'),
            'role' => 'hospital',
            'status' => 'Active',
            'location' => 'Philippines|Cebu|Mandaue City',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
            'phone' => '09111111111',
            'email_verified_at' => now(),
        ]);

        // STEP 2: Create Hospital A
        $hospitalA = Hospital::create([
            'user_id' => $hospitalUserA->id,
            'name' => 'Hospital A',
            'location' => 'Philippines|Cebu|Mandaue City',
        ]);

        // STEP 3: Create Hospital B user
        $hospitalUserB = User::create([
            'name' => 'Hospital B User',
            'email' => 'hospitalb@example.com',
            'password' => Hash::make('password123'),
            'role' => 'hospital',
            'status' => 'Active',
            'location' => 'Philippines|Cebu|Lapu-Lapu City',
            'birth_date' => '1991-01-01',
            'gender' => 'male',
            'phone' => '09222222222',
            'email_verified_at' => now(),
        ]);

        // STEP 4: Create Hospital B
        $hospitalB = Hospital::create([
            'user_id' => $hospitalUserB->id,
            'name' => 'Hospital B',
            'location' => 'Philippines|Cebu|Lapu-Lapu City',
        ]);

        // STEP 5: Login as Hospital A
        $this->actingAs($hospitalUserA);

        // STEP 6: Create blood request
        $response = $this->post(route('blood-requests.store'), [
            'blood_type' => 'A+',
            'quantity' => '2 bags',
            'urgency_lvl' => 'High',
        ]);

        $response->assertStatus(302);

        // STEP 7: Check blood request created
        $bloodRequest = BloodRequest::first();

        $this->assertNotNull($bloodRequest);

        $this->assertDatabaseHas('blood_requests', [
            'id' => $bloodRequest->id,
            'hospital_id' => $hospitalA->id,
            'blood_type' => 'A+',
            'quantity' => '2 bags',
            'urgency_lvl' => 'High',
            'status' => 'Pending',
        ]);

        // STEP 8: Login as Hospital B
        $this->actingAs($hospitalUserB);

        // STEP 9: Fulfill the blood request
        $response = $this->patch(route('blood-requests.fulfill', $bloodRequest->id));

        $response->assertStatus(302);

        // STEP 10: Check request is fulfilled by Hospital B
        $this->assertDatabaseHas('blood_requests', [
            'id' => $bloodRequest->id,
            'status' => 'Fulfilled',
            'confirmed_by' => $hospitalB->id,
        ]);
    }
}