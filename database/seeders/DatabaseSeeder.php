<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        \App\Models\User::factory(1)->is_admin()->create();
//        \App\Models\Address::factory(10)->create();

        \App\Models\User::factory(1)->is_admin()->create([
            'name' => 'Admin Almighty',
            'email' => 'admin@admin.com',
            'password' => 'StrongPassword123'
        ]);
    }
}
