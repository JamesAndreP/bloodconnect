<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class DeclineRescheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function hospital_can_decline_reschedule_request()
    {
        /** @var \App\Models\User $hospitalUser */
        $hospitalUser = User::factory()->create([
            'role' => 'hospital',
        ]);

        $this->actingAs($hospitalUser);

        /** @var \App\Models\User $donor */
        $donor = User::factory()->create([
            'role' => 'donor',
        ]);

        $hospitalId = DB::table('hospitals')->insertGetId([
            'user_id' => $hospitalUser->id,
            'name' => 'Test Hospital',
            'location' => 'Mandaue City',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $requestId = DB::table('donation_requests')->insertGetId([
            'user_id' => $donor->id,
            'hospital_id' => $hospitalId,
            'notes' => 'Donation request for reschedule decline',
            'status' => 'RescheduleRequest',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('donation_request_schedules')->insert([
            'donation_request_id' => $requestId,
            'date' => now()->addDays(2)->toDateString(),
            'notes' => 'Current active schedule',
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pendingScheduleId = DB::table('donation_request_schedules')->insertGetId([
            'donation_request_id' => $requestId,
            'date' => now()->addDays(7)->toDateString(),
            'notes' => 'Requested reschedule date',
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->patch("/donation-requests/reschedule/decline/{$pendingScheduleId}");

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('donation_requests', [
            'id' => $requestId,
            'status' => 'Approved',
        ]);

        $this->assertDatabaseHas('donation_request_schedules', [
            'id' => $pendingScheduleId,
            'donation_request_id' => $requestId,
            'notes' => 'Requested reschedule date',
            'status' => 'Declined',
        ]);

        $this->assertDatabaseHas('donation_request_schedules', [
            'donation_request_id' => $requestId,
            'notes' => 'Current active schedule',
            'status' => 'Active',
        ]);
    }

    /** @test */
    public function guest_cannot_decline_reschedule_request()
    {
        $response = $this->patch('/donation-requests/reschedule/decline/1');

        $response->assertRedirect('/login');
    }
}