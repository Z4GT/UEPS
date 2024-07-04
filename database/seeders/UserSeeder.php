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
            ],
            [
                'name' => 'Melanie',
                'last_name' => 'Ullco',
                'email' => 'melanierubi.mu@gmail.com',
                'password' => Hash::make('1234567'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password123'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'jane.doe@example.com',
                'password' => Hash::make('password123'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Michael',
                'last_name' => 'Smith',
                'email' => 'michael.smith@example.com',
                'password' => Hash::make('password123'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Emily',
                'last_name' => 'Johnson',
                'email' => 'emily.johnson@example.com',
                'password' => Hash::make('password123'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alec',
                'last_name' => 'Thompson',
                'email' => 'admin@corporateui.com ',
                'password' => Hash::make('secret'),
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
