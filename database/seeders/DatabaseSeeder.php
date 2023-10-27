<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        \App\Models\User::factory(1)->isAdmin()->create([
//            'name' => 'Admin Almighty',
//            'email' => 'admin@admin.com',
//            'password' => Hash::make('StrongPassword123')
//        ]);

//        \App\Models\User::factory(1)->isAdmin()->create();
        \App\Models\Address::factory(10)->create();
    }
}
