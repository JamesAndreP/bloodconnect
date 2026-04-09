<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class DonationRescheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function donor_can_submit_reschedule_request()
    {
        // Create donor and login
        $donor = User::factory()->create([
            'role' => 'donor',
        ]);
        $this->actingAs($donor);

        // Create hospital owner user (required by hospitals.user_id FK)
        $hospitalOwner = User::factory()->create([
            'role' => 'hospital',
        ]);

        // Create hospital record (required columns)
        $hospitalId = DB::table('hospitals')->insertGetId([
            'user_id' => $hospitalOwner->id,
            'name' => 'Test Hospital',
            'location' => 'Mandaue City',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create donation request record (matches your donation_requests table)
        $requestId = DB::table('donation_requests')->insertGetId([
            'user_id' => $donor->id,
            'hospital_id' => $hospitalId,
            'notes' => 'Initial request',
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Submit reschedule (controller expects 'date' and optional 'notes')
        $response = $this->patch("/donation-requests/reschedule/{$requestId}", [
            'date' => now()->addDays(7)->toDateString(),
            'notes' => 'Need to reschedule due to conflict',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('donation_requests', [
            'id' => $requestId,
        ]);
    }

    /** @test */
    public function guest_cannot_reschedule_donation_request()
    {
        $response = $this->patch('/donation-requests/reschedule/1', [
            'date' => now()->addDays(7)->toDateString(),
            'notes' => 'Trying without login',
        ]);

        $response->assertRedirect('/login');
    }
}