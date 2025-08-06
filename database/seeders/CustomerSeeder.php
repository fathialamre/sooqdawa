<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all countries
        $countries = Country::all();

        if ($countries->isEmpty()) {
            $this->command->error('Please run CountriesSeeder first.');
            return;
        }

        // Sample customer data with Arabic names (Limited to 10 users)
        $customers = [
            [
                'name' => 'أحمد محمد علي',
                'email' => 'ahmed.mohamed@example.com',
                'type' => 'customer',
                'is_active' => true,
            ],
            [
                'name' => 'فاطمة أحمد السعيد',
                'email' => 'fatima.ahmed@example.com',
                'type' => 'customer',
                'is_active' => true,
            ],
            [
                'name' => 'محمد عبدالله الطيب',
                'email' => 'mohamed.abdullah@example.com',
                'type' => 'customer',
                'is_active' => true,
            ],
            [
                'name' => 'عائشة خالد المختار',
                'email' => 'aisha.khalid@example.com',
                'type' => 'customer',
                'is_active' => true,
            ],
            [
                'name' => 'عمر حسن البوسيفي',
                'email' => 'omar.hassan@example.com',
                'type' => 'customer',
                'is_active' => true,
            ],
            [
                'name' => 'خديجة محمود الزين',
                'email' => 'khadija.mahmoud@example.com',
                'type' => 'customer',
                'is_active' => true,
            ],
            [
                'name' => 'يوسف إبراهيم الصغير',
                'email' => 'youssef.ibrahim@example.com',
                'type' => 'customer',
                'is_active' => true,
            ],
            [
                'name' => 'زينب أحمد الكبير',
                'email' => 'zainab.ahmed@example.com',
                'type' => 'customer',
                'is_active' => true,
            ],
            [
                'name' => 'علي محمد الشريف',
                'email' => 'ali.mohamed@example.com',
                'type' => 'customer',
                'is_active' => true,
            ],
            [
                'name' => 'مريم عبدالسلام النجار',
                'email' => 'mariam.abdussalam@example.com',
                'type' => 'customer',
                'is_active' => true,
            ],
        ];

        $createdUsers = [];
        foreach ($customers as $customerData) {
            $user = User::create([
                'name' => $customerData['name'],
                'email' => $customerData['email'],
                'password' => Hash::make('password123'), // Default password for all customers
                'type' => $customerData['type'],
                'is_active' => $customerData['is_active'],
                'country_id' => $countries->random()->id, // Assign random country
                'email_verified_at' => now(),
            ]);
            $createdUsers[] = $user;
        }

        // Add followers and following relationships
        $this->command->info('Adding followers and following relationships...');
        
        foreach ($createdUsers as $user) {
            // Get random users to follow (excluding self)
            $usersToFollow = collect($createdUsers)
                ->where('id', '!=', $user->id)
                ->random(rand(2, 5)) // Each user follows 2-5 random users
                ->pluck('id')
                ->toArray();
            
            // Attach following relationships
            $user->following()->attach($usersToFollow);
        }

        $this->command->info('Customer seeder completed successfully! Created ' . count($customers) . ' customers with random countries and follower relationships.');
    }
}