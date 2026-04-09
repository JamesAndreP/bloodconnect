<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExportPdfTest extends TestCase
{
    use RefreshDatabase;

    protected function adminUser()
    {
        return User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_it_can_export_users_pdf()
    {
        $user = $this->adminUser();

        $response = $this->actingAs($user)->get('/export/users/pdf');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_it_can_export_hospitals_pdf()
    {
        $user = $this->adminUser();

        $response = $this->actingAs($user)->get('/export/hospitals/pdf');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_it_can_export_donation_requests_pdf()
    {
        $user = $this->adminUser();

        $response = $this->actingAs($user)->get('/export/donation-requests/pdf');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_it_can_export_blood_requests_pdf()
    {
        $user = $this->adminUser();

        $response = $this->actingAs($user)->get('/export/blood-requests/pdf');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}