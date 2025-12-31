<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Tempe 3 Puteri',
            'email' => 'admin@tempe3puteri.local',
            'is_admin' => true,
            'password' => Hash::make('password'), // Change in production!
        ]);
    }
}
