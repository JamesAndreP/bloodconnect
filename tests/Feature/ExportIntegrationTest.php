<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExportIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_export_users_excel()
    {
        // STEP 1: Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'Active',
            'location' => 'Philippines|Cebu|Mandaue City',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
            'phone' => '09111111111',
            'email_verified_at' => now(),
        ]);

        // STEP 2: Login as admin
        $this->actingAs($admin);

        // STEP 3: Call export route
        $response = $this->get(route('export.users'));

        // STEP 4: Assert response
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /** @test */
    public function admin_can_export_donation_requests_excel()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'Active',
            'location' => 'Philippines|Cebu|Mandaue City',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
            'phone' => '09111111111',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('export.donation-requests'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /** @test */
    public function admin_can_export_users_pdf()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin3@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'status' => 'Active',
            'location' => 'Philippines|Cebu|Mandaue City',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
            'phone' => '09111111111',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('export.users.pdf'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}