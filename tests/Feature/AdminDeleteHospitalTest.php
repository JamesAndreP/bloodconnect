<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class AdminDeleteHospitalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_delete_hospital()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $hospitalUserId = DB::table('users')->insertGetId([
            'name' => 'Hospital User',
            'email' => 'deletehospital@example.com',
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
            'name' => 'Hospital To Delete',
            'location' => 'Mandaue City',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->delete("/hospitals/{$hospitalId}");

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        // Hospital is soft deleted
        $this->assertDatabaseHas('hospitals', [
            'id' => $hospitalId,
            'name' => 'Hospital To Delete',
        ]);

        $this->assertNotNull(
            DB::table('hospitals')->where('id', $hospitalId)->value('deleted_at')
        );
    }

    /** @test */
    public function guest_cannot_delete_hospital()
    {
        $response = $this->delete('/hospitals/1');

        $response->assertRedirect('/login');
    }
}