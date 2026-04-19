<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin account
        $this->call(AdminSeeder::class);

        // Create test user
        User::factory()->create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'role' => 'member',
        ]);
    }
}
