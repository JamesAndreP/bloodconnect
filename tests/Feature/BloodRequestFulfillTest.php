<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class BloodRequestFulfillTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function hospital_can_fulfill_blood_request()
    {
        // create hospital user
        $hospitalUser = User::factory()->create([
            'role' => 'hospital',
        ]);

        $this->actingAs($hospitalUser);

        // create hospital
        $hospitalId = DB::table('hospitals')->insertGetId([
            'user_id' => $hospitalUser->id,
            'name' => 'Test Hospital',
            'location' => 'Cebu City',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // create blood request
        $bloodRequestId = DB::table('blood_requests')->insertGetId([
            'hospital_id' => $hospitalId,
            'blood_type' => 'A+',
            'quantity' => '2 bags',
            'urgency_lvl' => 'High',
            'request_date' => now(),
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // fulfill request
        $response = $this->patch("/blood-requests/fulfill/{$bloodRequestId}");

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        // verify database update
        $this->assertDatabaseHas('blood_requests', [
            'id' => $bloodRequestId,
            'status' => 'Fulfilled',
            'confirmed_by' => $hospitalId,
        ]);
    }

    /** @test */
    public function guest_cannot_fulfill_blood_request()
    {
        $response = $this->patch('/blood-requests/fulfill/1');

        $response->assertRedirect('/login');
    }
}