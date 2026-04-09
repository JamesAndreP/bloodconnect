<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminViewHospitalsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_hospitals_page()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->get('/hospitals');

        $response->assertStatus(200);
    }

    /** @test */
    public function guest_cannot_view_hospitals_page()
    {
        $response = $this->get('/hospitals');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function donor_cannot_view_hospitals_page()
    {
        /** @var \App\Models\User $donor */
        $donor = User::factory()->create([
            'role' => 'donor',
        ]);

        $this->actingAs($donor);

        $response = $this->get('/hospitals');

        $response->assertStatus(403);
    }

    /** @test */
    public function hospital_user_cannot_view_hospitals_page()
    {
        /** @var \App\Models\User $hospital */
        $hospital = User::factory()->create([
            'role' => 'hospital',
        ]);

        $this->actingAs($hospital);

        $response = $this->get('/hospitals');

        $response->assertStatus(403);
    }
}