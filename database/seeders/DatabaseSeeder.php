<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Todo; 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat 1 user admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => true
        ]);

        // Membuat 100 user
        User::factory(100)->create();

        // Membuat 500 todo
        Todo::factory(500)->create();
    }
}
