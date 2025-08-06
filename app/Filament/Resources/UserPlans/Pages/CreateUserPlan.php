<?php

namespace App\Filament\Resources\UserPlans\Pages;

use App\Filament\Resources\UserPlans\UserPlanResource;
use App\Models\Plan;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUserPlan extends CreateRecord
{
    protected static string $resource = UserPlanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Get the plan to calculate duration
        $plan = Plan::find($data['plan_id']);
        
        // Calculate dates based on plan duration
        $startsAt = now();
        $endsAt = $startsAt->copy()->addMonths($plan->duration_months);
        
        return array_merge($data, [
            'status' => 'active',
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'expired_at' => $endsAt,
            'is_expired' => false,
            'cancelled_at' => null,
        ]);
    }

    protected function afterCreate(): void
    {
        // Cancel any existing active plan for this user
        $userPlan = $this->record;
        $userPlan->user->userPlans()
            ->where('status', 'active')
            ->where('id', '!=', $userPlan->id)
            ->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
