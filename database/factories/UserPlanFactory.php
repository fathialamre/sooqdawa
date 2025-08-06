<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPlan>
 */
class UserPlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserPlan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['active', 'cancelled', 'expired']);
        $startsAt = $this->faker->dateTimeBetween('-6 months', 'now');
        $plan = Plan::inRandomOrder()->first() ?? Plan::factory()->create();
        $endsAt = $startsAt->modify('+' . $plan->duration_months . ' months');
        
        $isExpired = $status === 'expired' || $endsAt < now();
        $expiredAt = $isExpired ? $this->faker->dateTimeBetween($startsAt, $endsAt) : $endsAt;
        $cancelledAt = $status === 'cancelled' ? $this->faker->dateTimeBetween($startsAt, $endsAt) : null;

        return [
            'user_id' => User::factory(),
            'plan_id' => $plan->id,
            'status' => $status,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'expired_at' => $expiredAt,
            'is_expired' => $isExpired,
            'cancelled_at' => $cancelledAt,
        ];
    }

    /**
     * Indicate that the user plan is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'is_expired' => false,
            'starts_at' => now()->subDays(rand(1, 30)),
            'ends_at' => now()->addMonths(rand(1, 12)),
            'expired_at' => now()->addMonths(rand(1, 12)),
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the user plan is expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'expired',
            'is_expired' => true,
            'starts_at' => now()->subMonths(rand(2, 6)),
            'ends_at' => now()->subDays(rand(1, 30)),
            'expired_at' => now()->subDays(rand(1, 30)),
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the user plan is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'is_expired' => false,
            'starts_at' => now()->subDays(rand(1, 30)),
            'ends_at' => now()->addMonths(rand(1, 12)),
            'expired_at' => now()->addMonths(rand(1, 12)),
            'cancelled_at' => now()->subDays(rand(1, 15)),
        ]);
    }
}
