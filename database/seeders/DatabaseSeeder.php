<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed countries first (required for admin users)
        $this->call([
            CountriesSeeder::class,
            AdminSeeder::class,
            CitySeeder::class,
            CountriesSeeder::class,
            DepartmentSeeder::class,
            CustomerSeeder::class,
            PostSeederUpdated::class,
            CommentSeeder::class,
            LikeSeeder::class,
            VoucherSeeder::class,
            VoucherStockSeeder::class,
            BannerSeeder::class,
            ComplaintSeeder::class,
            OffensiveWordSeeder::class,
            PlanSeeder::class,
        ]);

        // User::factory(10)->create();

        // Optional: Create test users for development
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
