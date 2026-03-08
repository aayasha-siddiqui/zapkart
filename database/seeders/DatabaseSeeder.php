<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ❌ REMOVE user factory
        // User::factory(10)->create();
        // User::factory()->create([...]);

        // ✅ Only run these:
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
        $this->call([
        AdminSeeder::class,
    ]);
    }
}
