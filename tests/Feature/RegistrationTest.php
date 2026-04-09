<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test Donor',
            'email' => 'donor@test.com',
            'password' => 'password123',
            'location' => 'Cebu City',
            'birth_date' => '2000-01-01',
            'gender' => 'male',
            'phone' => '09123456789',
            'agreement' => 'on'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'email' => 'donor@test.com'
        ]);
    }

    /** @test */
    public function registration_requires_valid_data()
    {
        $response = $this->post('/register', []);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'password',
            'location',
            'birth_date',
            'gender',
            'phone',
            'agreement'
        ]);
    }
}