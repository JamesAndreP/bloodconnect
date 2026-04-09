<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class ApproveRescheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function hospital_can_approve_reschedule_request()
    {
        // Create hospital user and login
        $hospitalUser = User::factory()->create([
            'role' => 'hospital',
        ]);

        $this->actingAs($hospitalUser);

        // Create donor
        $donor = User::factory()->create([
            'role' => 'donor',
        ]);

        // Create hospital record
        $hospitalId = DB::table('hospitals')->insertGetId([
            'user_id' => $hospitalUser->id,
            'name' => 'Test Hospital',
            'location' => 'Mandaue City',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create donation request
        $requestId = DB::table('donation_requests')->insertGetId([
            'user_id' => $donor->id,
            'hospital_id' => $hospitalId,
            'notes' => 'Donation request for reschedule approval',
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Existing active schedule
        DB::table('donation_request_schedules')->insert([
            'donation_request_id' => $requestId,
            'date' => now()->addDays(2)->toDateString(),
            'notes' => 'Current active schedule',
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Pending reschedule request schedule
        $pendingScheduleId = DB::table('donation_request_schedules')->insertGetId([
            'donation_request_id' => $requestId,
            'date' => now()->addDays(7)->toDateString(),
            'notes' => 'Requested reschedule date',
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Approve the reschedule request
        $response = $this->patch("/donation-requests/reschedule/approve/{$pendingScheduleId}");

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        // Donation request should now be approved
        $this->assertDatabaseHas('donation_requests', [
            'id' => $requestId,
            'status' => 'Approved',
        ]);

        // Old active schedule should now be inactive
        $this->assertDatabaseHas('donation_request_schedules', [
            'donation_request_id' => $requestId,
            'notes' => 'Current active schedule',
            'status' => 'Inactive',
        ]);

        // Selected pending schedule should now be active
        $this->assertDatabaseHas('donation_request_schedules', [
            'id' => $pendingScheduleId,
            'donation_request_id' => $requestId,
            'notes' => 'Requested reschedule date',
            'status' => 'Active',
        ]);
    }

    /** @test */
    public function guest_cannot_approve_reschedule_request()
    {
        $response = $this->patch('/donation-requests/reschedule/approve/1');

        $response->assertRedirect('/login');
    }
}