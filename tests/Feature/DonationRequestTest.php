<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DonationRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function donor_can_submit_donation_request()
    {
        $user = User::factory()->create([
            'role' => 'donor'
        ]);

        $this->actingAs($user);

        $response = $this->post('/donation-requests', [
            'hospital_id' => 1,
            'donation_date' => now()->addDays(3)
        ]);

        $response->assertStatus(302);
    }

    /** @test */
    public function guest_cannot_submit_donation_request()
    {
        $response = $this->post('/donation-requests', [
            'hospital_id' => 1,
            'donation_date' => now()->addDays(3)
        ]);

        $response->assertRedirect('/login');
    }
}