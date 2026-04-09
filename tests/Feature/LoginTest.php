<?php

namespace Tests\Feature;

use App\Models\User;
use App\Enums\UserRoleEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_login_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        // Create test user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
            'role' => UserRoleEnum::Donor->value,
            'gender' => 'male',
            'birth_date' => '2000-01-01',
            'status' => 'active', // added since your DB requires this
        ]);

        // Post to correct login endpoint
        $response = $this->post('/session', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Expect redirect to dashboard
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cannot_login_with_invalid_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => UserRoleEnum::Donor->value,
            'gender' => 'male',
            'birth_date' => '2000-01-01',
            'status' => 'active',
        ]);

        // Wrong password
        $response = $this->post('/session', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
}
