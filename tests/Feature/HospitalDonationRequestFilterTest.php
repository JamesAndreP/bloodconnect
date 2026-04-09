<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class HospitalDonationRequestFilterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function hospital_can_view_donation_requests_sorted_by_newest()
    {
        // Create hospital user
        $hospitalUser = User::factory()->create([
            'role' => 'hospital',
        ]);

        $this->actingAs($hospitalUser);

        // Create hospital record
        $hospitalId = DB::table('hospitals')->insertGetId([
            'user_id' => $hospitalUser->id,
            'name' => 'Test Hospital',
            'location' => 'Mandaue',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create donor
        $donor = User::factory()->create([
            'role' => 'donor',
        ]);

        // Create OLD request
        DB::table('donation_requests')->insert([
            'user_id' => $donor->id,
            'hospital_id' => $hospitalId,
            'notes' => 'Old Request',
            'status' => 'Pending',
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(5),
        ]);

        // Create NEW request
        DB::table('donation_requests')->insert([
            'user_id' => $donor->id,
            'hospital_id' => $hospitalId,
            'notes' => 'New Request',
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Request newest sorting
        $response = $this->get('/donation-requests/hospital?sort=newest');

        $response->assertStatus(200);
    }

    /** @test */
    public function hospital_can_view_donation_requests_sorted_by_oldest()
    {
        // Create hospital user
        $hospitalUser = User::factory()->create([
            'role' => 'hospital',
        ]);

        $this->actingAs($hospitalUser);

        // Create hospital record
        $hospitalId = DB::table('hospitals')->insertGetId([
            'user_id' => $hospitalUser->id,
            'name' => 'Test Hospital',
            'location' => 'Mandaue',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create donor
        $donor = User::factory()->create([
            'role' => 'donor',
        ]);

        // Create OLD request
        DB::table('donation_requests')->insert([
            'user_id' => $donor->id,
            'hospital_id' => $hospitalId,
            'notes' => 'Old Request',
            'status' => 'Pending',
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(5),
        ]);

        // Create NEW request
        DB::table('donation_requests')->insert([
            'user_id' => $donor->id,
            'hospital_id' => $hospitalId,
            'notes' => 'New Request',
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Request oldest sorting
        $response = $this->get('/donation-requests/hospital?sort=oldest');

        $response->assertStatus(200);
    }

    /** @test */
    public function guest_cannot_access_hospital_donation_requests()
    {
        $response = $this->get('/donation-requests/hospital');

        $response->assertRedirect('/login');
    }
}