<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilteredExportPdfTest extends TestCase
{
    use RefreshDatabase;

    protected function adminUser()
    {
        return User::factory()->create([
            'role' => 'admin',
        ]);
    }

    /** @test */
    public function admin_can_export_filtered_users_pdf()
    {
        $user = $this->adminUser();

        $response = $this->actingAs($user)->get('/export/filter/pdf?report=users&from=2024-01-01&to=2026-12-31');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /** @test */
    public function admin_can_export_filtered_hospitals_pdf()
    {
        $user = $this->adminUser();

        $response = $this->actingAs($user)->get('/export/filter/pdf?report=hospitals&from=2024-01-01&to=2026-12-31');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /** @test */
    public function admin_can_export_filtered_donation_requests_pdf()
    {
        $user = $this->adminUser();

        $response = $this->actingAs($user)->get('/export/filter/pdf?report=donation&from=2024-01-01&to=2026-12-31');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /** @test */
    public function admin_can_export_filtered_blood_requests_pdf()
    {
        $user = $this->adminUser();

        $response = $this->actingAs($user)->get('/export/filter/pdf?report=blood&from=2024-01-01&to=2026-12-31');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    /** @test */
    public function invalid_report_returns_error()
    {
        $user = $this->adminUser();

        $response = $this->actingAs($user)->get('/export/filter/pdf?report=invalid');

        $response->assertStatus(302);
        $response->assertSessionHas('error');
    }
}