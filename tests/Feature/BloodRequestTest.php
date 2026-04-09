<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class BloodRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function hospital_can_create_blood_request()
    {
        // Create hospital user and login
        $hospitalUser = User::factory()->create([
            'role' => 'hospital',
        ]);

        $this->actingAs($hospitalUser);

        // Create hospital record
        $hospitalId = DB::table('hospitals')->insertGetId([
            'user_id' => $hospitalUser->id,
            'name' => 'Test Hospital',
            'location' => 'Cebu City',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send blood request
        $response = $this->post('/blood-requests', [
            'blood_type' => 'A+',
            'quantity' => '5',
            'urgency_lvl' => 'High',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        // Check database
        $this->assertDatabaseHas('blood_requests', [
            'hospital_id' => $hospitalId,
            'blood_type' => 'A+',
            'quantity' => '5',
            'urgency_lvl' => 'High',
        ]);
    }

    /** @test */
    public function guest_cannot_create_blood_request()
    {
        $response = $this->post('/blood-requests', [
            'blood_type' => 'O+',
            'quantity' => '3',
            'urgency_lvl' => 'Low',
        ]);

        $response->assertRedirect('/login');
    }
}