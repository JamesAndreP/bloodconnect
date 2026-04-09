<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCreateHospitalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_hospital()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->actingAs($admin);

        $response = $this->post('/hospitals/store', [
            'hospital_name' => 'Test Hospital',
            'hospital_location' => 'Cebu City',

            'user_name' => 'Hospital Admin',
            'user_email' => 'hospital@test.com',
            'user_password' => 'password123',
            'user_birth_date' => '1990-01-01',
            'user_gender' => 'MALE',
            'user_phone' => '09123456789',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }

    /** @test */
    public function guest_cannot_create_hospital()
    {
        $response = $this->post('/hospitals/store', [
            'hospital_name' => 'Test Hospital'
        ]);

        $response->assertRedirect('/login');
    }
}