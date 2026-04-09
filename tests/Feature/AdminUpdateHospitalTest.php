<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class AdminUpdateHospitalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_update_hospital()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $hospitalUserId = DB::table('users')->insertGetId([
            'name' => 'Old Hospital User',
            'email' => 'oldhospital@example.com',
            'password' => bcrypt('password123'),
            'role' => 'hospital',
            'birth_date' => '1990-01-01',
            'gender' => 'MALE',
            'phone' => '09123456789',
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $hospitalId = DB::table('hospitals')->insertGetId([
            'user_id' => $hospitalUserId,
            'name' => 'Old Hospital Name',
            'location' => 'Old Location',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->patch("/hospitals/{$hospitalId}", [
            'hospital_id' => (string) $hospitalId,
            'hospital_name' => 'Updated Hospital Name',
            'hospital_location' => 'Updated Location',

            'user_id' => (string) $hospitalUserId,
            'user_name' => 'Updated Hospital User',
            'user_email' => 'updatedhospital@example.com',
            'user_password' => 'newpassword123',
            'user_birth_date' => '1991-02-02',
            'user_gender' => 'FEMALE',
            'user_phone' => '09987654321',
            'user_status' => 'Active',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('hospitals', [
            'id' => $hospitalId,
            'name' => 'Updated Hospital Name',
            'location' => 'Updated Location',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $hospitalUserId,
            'name' => 'Updated Hospital User',
            'email' => 'updatedhospital@example.com',
            'birth_date' => '1991-02-02',
            'gender' => 'FEMALE',
            'phone' => '09987654321',
            'status' => 'Active',
        ]);
    }

    /** @test */
    public function guest_cannot_update_hospital()
    {
        $response = $this->patch('/hospitals/1', [
            'hospital_id' => '1',
            'hospital_name' => 'Updated Hospital Name',
            'hospital_location' => 'Updated Location',
            'user_id' => '1',
            'user_name' => 'Updated Hospital User',
            'user_email' => 'updatedhospital@example.com',
            'user_birth_date' => '1991-02-02',
            'user_gender' => 'FEMALE',
            'user_phone' => '09987654321',
            'user_status' => 'Active',
        ]);

        $response->assertRedirect('/login');
    }
}