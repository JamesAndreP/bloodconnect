<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register_verify_otp_and_access_dashboard()
    {
        // STEP 1: Register user
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'location' => 'Philippines|Cebu|Mandaue City',
            'birth_date' => '2000-01-01',
            'gender' => 'Male',
            'phone' => '09123456789',
            'agreement' => '1',
        ]);

        $response->assertRedirect(route('otp', ['email' => 'test@example.com']));

        $user = User::where('email', 'test@example.com')->first();

        $this->assertNotNull($user);
        $this->assertNull($user->email_verified_at);
        $this->assertNotNull($user->otp);

        // STEP 2: Verify OTP using the generated OTP
        $response = $this->post('/verify-otp', [
            'email' => $user->email,
            'otp' => $user->otp,
        ]);

        $response->assertRedirect('/dashboard');

        $user = $user->fresh();

        $this->assertNotNull($user->email_verified_at);
        $this->assertNull($user->otp);
        $this->assertNull($user->otp_expires_at);

        // STEP 3: Confirm authenticated and can access dashboard
        $this->assertAuthenticatedAs($user);

        $dashboard = $this->get('/dashboard');
        $dashboard->assertStatus(200);
    }
}