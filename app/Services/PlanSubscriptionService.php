<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlan;
use Exception;

class PlanSubscriptionService
{
    /**
     * Subscribe a user to a plan
     * 
     * @param User $user
     * @param Plan $plan
     * @param bool $forceCancel - If true, automatically cancel existing plan without confirmation
     * @return array
     */
    public function subscribeToPlan(User $user, Plan $plan, bool $forceCancel = false): array
    {
        // Check if user has an active plan
        $activePlan = $user->getCurrentPlan();
        
        if ($activePlan && !$forceCancel) {
            return [
                'status' => 'confirmation_required',
                'message' => __('messages.plans.active_plan_exists'),
                'data' => [
                    'current_plan' => [
                        'id' => $activePlan->plan->id,
                        'name' => $activePlan->plan->name,
                        'ends_at' => $activePlan->ends_at->format('Y-m-d H:i:s'),
                    ],
                    'new_plan' => [
                        'id' => $plan->id,
                        'name' => $plan->name,
                        'price' => $plan->price,
                        'duration_months' => $plan->duration_months,
                        'number_of_posts' => $plan->number_of_posts,
                        'feature_posts' => $plan->feature_posts,
                    ]
                ]
            ];
        }

        try {
            // Cancel active plan if exists
            if ($activePlan) {
                $activePlan->cancel();
            }

            // Subscribe to new plan
            $userPlan = $user->subscribeToPlan($plan, false);

            return [
                'status' => 'success',
                'message' => __('messages.plans.subscription_successful'),
                'data' => [
                    'user_plan' => $userPlan,
                    'plan' => $plan
                ]
            ];

        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => __('messages.plans.subscription_failed'),
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Confirm plan subscription after user approval
     */
    public function confirmPlanSubscription(User $user, Plan $plan): array
    {
        return $this->subscribeToPlan($user, $plan, true);
    }

    /**
     * Cancel user's active plan
     */
    public function cancelActivePlan(User $user): array
    {
        $activePlan = $user->getCurrentPlan();
        
        if (!$activePlan) {
            return [
                'status' => 'error',
                'message' => __('messages.plans.no_active_plan')
            ];
        }

        try {
            $activePlan->cancel();
            
            return [
                'status' => 'success',
                'message' => __('messages.plans.cancellation_successful')
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => __('messages.plans.cancellation_failed'),
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get user's plan status
     */
    public function getUserPlanStatus(User $user): array
    {
        $activePlan = $user->getCurrentPlan();
        
        if (!$activePlan) {
            return [
                'status' => 'no_plan',
                'message' => __('messages.plans.no_active_plan'),
                'data' => null
            ];
        }

        return [
            'status' => 'active',
            'message' => __('messages.plans.plan_active'),
            'data' => [
                'plan' => $activePlan->plan,
                'user_plan' => $activePlan,
                'starts_at' => $activePlan->starts_at->format('Y-m-d H:i:s'),
                'ends_at' => $activePlan->ends_at->format('Y-m-d H:i:s'),
                'days_remaining' => $activePlan->ends_at->diffInDays(now())
            ]
        ];
    }

    /**
     * Get all available plans
     */
    public function getAvailablePlans(): array
    {
        $plans = Plan::active()->get();
        
        return [
            'status' => 'success',
            'data' => $plans->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'price' => $plan->price,
                    'duration_months' => $plan->duration_months,
                    'description' => $plan->description,
                    'number_of_posts' => $plan->number_of_posts,
                    'feature_posts' => $plan->feature_posts,
                    'avatar_url' => $plan->avatar_url,
                    'avatar_thumb_url' => $plan->avatar_thumb_url,
                ];
            })
        ];
    }
}