<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@spotlight.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@spotlight.com',
                'phone' => '+265888000000',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'registration_status' => 'completed',
                'registered_at' => now(),
            ]
        );
    }
}
