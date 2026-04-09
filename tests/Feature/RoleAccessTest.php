<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_access_dashboard()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login'); // or '/' depending on your setup
    }

    /** @test */
    public function donor_cannot_access_hospital_routes()
    {
        $donor = User::create([
            'name' => 'Donor',
            'email' => 'donor@test.com',
            'password' => Hash::make('password'),
            'role' => 'donor',
            'status' => 'Active',
            'location' => 'Philippines|Cebu|Mandaue City',
            'birth_date' => '2000-01-01',
            'gender' => 'male',
            'phone' => '09111111111',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($donor);

        // Try accessing hospital-only route
        $response = $this->get('/donation-requests/hospital');

        $response->assertStatus(403);
    }

    /** @test */
    public function hospital_cannot_access_admin_exports()
    {
        $hospital = User::create([
            'name' => 'Hospital',
            'email' => 'hospital@test.com',
            'password' => Hash::make('password'),
            'role' => 'hospital',
            'status' => 'Active',
            'location' => 'Philippines|Cebu|Mandaue City',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
            'phone' => '09222222222',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($hospital);

        // Try accessing admin export
        $response = $this->get(route('export.users'));

        // depends on your middleware
        $response->assertStatus(403);
    }
}