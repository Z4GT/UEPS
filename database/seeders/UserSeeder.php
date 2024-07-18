<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Diego',
                'last_name' => 'Recalde',
                'email' => 'diegodavidrecalde@gmail.com',
                'password' => Hash::make('diego123'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'John',
                'last_name' => 'Doe',
                'email' => 'auditor@example.com',
                'password' => Hash::make('password123'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'rector@example.com',
                'password' => Hash::make('password123'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Michael',
                'last_name' => 'Smith',
                'email' => 'coordinador@example.com',
                'password' => Hash::make('password123'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Emily',
                'last_name' => 'Johnson',
                'email' => 'administrador@example.com',
                'password' => Hash::make('password123'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Alec',
                'last_name' => 'Thompson',
                'email' => 'admin@corporateui.com ',
                'password' => Hash::make('secret'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Zamyr',
                'last_name' => 'Guevara',
                'email' => 'admin@ueps.com',
                'password' => Hash::make('secret'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Alejandro',
                'last_name' => 'Mallama',
                'email' => 'alejo@ueps.com',
                'password' => Hash::make('Alejo123'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Melanie',
                'last_name' => 'Ullco',
                'email' => 'melanierubi.mu@gmail.com',
                'password' => Hash::make('1234567'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
        ]);
    }
}
