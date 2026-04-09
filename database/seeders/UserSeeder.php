<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@bloodconnect.com',
            'password' => Hash::make('secret'),
            'role' => 'admin',
            // 'blood_type' => 'A+',
            'location' => '75.05890, 103.03571',
            'birth_date' => '2000-01-01',
            'gender' => 'Male',
            'phone' => 123456789,
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
