<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\PlanSubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PlanController extends Controller
{
    public function __construct(
        private PlanSubscriptionService $planSubscriptionService
    ) {}

    /**
     * Display a listing of available plans.
     */
    public function index(): JsonResponse
    {
        $result = $this->planSubscriptionService->getAvailablePlans();
        
        return response()->json($result);
    }

    /**
     * Subscribe user to a plan.
     */
    public function subscribe(Request $request): JsonResponse
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $user = Auth::user();

        $result = $this->planSubscriptionService->subscribeToPlan($user, $plan);

        $statusCode = match($result['status']) {
            'success' => 200,
            'confirmation_required' => 200,
            'error' => 400,
            default => 500
        };

        return response()->json($result, $statusCode);
    }

    /**
     * Confirm plan subscription after user approval.
     */
    public function confirmSubscription(Request $request): JsonResponse
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->plan_id);
        $user = Auth::user();

        $result = $this->planSubscriptionService->confirmPlanSubscription($user, $plan);

        $statusCode = $result['status'] === 'success' ? 200 : 400;

        return response()->json($result, $statusCode);
    }

    /**
     * Get user's current plan status.
     */
    public function status(): JsonResponse
    {
        $user = Auth::user();
        $result = $this->planSubscriptionService->getUserPlanStatus($user);

        return response()->json($result);
    }

    /**
     * Cancel user's active plan.
     */
    public function cancel(): JsonResponse
    {
        $user = Auth::user();
        $result = $this->planSubscriptionService->cancelActivePlan($user);

        $statusCode = $result['status'] === 'success' ? 200 : 400;

        return response()->json($result, $statusCode);
    }

    /**
     * Display the specified plan.
     */
    public function show(string $id): JsonResponse
    {
        $plan = Plan::with('activeUserPlans')->findOrFail($id);
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $plan->id,
                'name' => $plan->name,
                'price' => $plan->price,
                'duration_months' => $plan->duration_months,
                'description' => $plan->description,
                'number_of_posts' => $plan->number_of_posts,
                'feature_posts' => $plan->feature_posts,
                'avatar_url' => $plan->avatar_url,
                'avatar_thumb_url' => $plan->avatar_thumb_url,
                'active_subscriptions_count' => $plan->activeUserPlans->count(),
            ]
        ]);
    }
}
