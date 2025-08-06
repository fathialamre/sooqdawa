<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define Libyan cities
        $cities = [
            'طرابلس',
            'الزاوية',
            'بنغازي',
            'سرت',
            'ترهونة',
            'مسلاته',
            'الخمس',
            'مصراته',
            'زليتن',
            'درنة',
            'طبرق',
            'غريان',
        ];

        foreach ($cities as $cityName) {
            City::create([
                'name' => $cityName,
                'is_active' => true,
            ]);

            $this->command->info("Created city: {$cityName}");
        }

        $this->command->info('City seeder completed successfully!');
    }
}
