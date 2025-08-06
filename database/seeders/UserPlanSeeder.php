<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $plans = Plan::all();

        if ($users->isEmpty()) {
            $this->command->info('No users found. Creating some users first...');
            $users = User::factory(10)->create();
        }

        if ($plans->isEmpty()) {
            $this->command->info('No plans found. Creating some plans first...');
            $plans = Plan::factory(3)->create();
        }

        // Create user plans for each user
        foreach ($users as $user) {
            // Each user can have multiple plans (but only one active at a time)
            $numberOfPlans = rand(1, 3);
            
            for ($i = 0; $i < $numberOfPlans; $i++) {
                $plan = $plans->random();
                $status = $this->getRandomStatus();
                
                $userPlan = UserPlan::factory()
                    ->state([
                        'user_id' => $user->id,
                        'plan_id' => $plan->id,
                        'status' => $status,
                    ])
                    ->create();

                // Ensure only one active plan per user
                if ($status === 'active') {
                    UserPlan::where('user_id', $user->id)
                        ->where('id', '!=', $userPlan->id)
                        ->where('status', 'active')
                        ->update([
                            'status' => 'cancelled',
                            'cancelled_at' => now(),
                        ]);
                }
            }
        }

        $this->command->info('User plans seeded successfully!');
    }

    /**
     * Get a random status with weighted distribution
     */
    private function getRandomStatus(): string
    {
        $weights = [
            'active' => 40,    // 40% chance
            'expired' => 35,   // 35% chance
            'cancelled' => 25, // 25% chance
        ];

        $random = rand(1, 100);
        $cumulative = 0;

        foreach ($weights as $status => $weight) {
            $cumulative += $weight;
            if ($random <= $cumulative) {
                return $status;
            }
        }

        return 'active';
    }
}
