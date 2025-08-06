<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a country (preferably Libya or Saudi Arabia as examples)
        $country = Country::where('iso', 'LY')->first() ?? Country::where('iso', 'SA')->first() ?? Country::first();

        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@sooqdawa.com'],
            [
                'name' => 'مدير النظام',
                'email' => 'admin@sooqdawa.com',
                'password' => Hash::make('password'),
                'type' => 'admin',
                'is_active' => true,
                'country_id' => $country?->id,
                'email_verified_at' => now(),
            ]
        );

        // Optional: Create a second admin user with different credentials
        User::firstOrCreate(
            ['email' => 'alamre@sooqdawa.com'],
            [
                'name' => 'أحمد المرعي',
                'email' => 'alamre@sooqdawa.com',
                'password' => Hash::make('admin123'),
                'type' => 'admin',
                'is_active' => true,
                'country_id' => $country?->id,
                'email_verified_at' => now(),
            ]
        );
    }
}