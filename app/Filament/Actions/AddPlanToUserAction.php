<?php

namespace App\Filament\Actions;

use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlan;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Notifications\Notification;

class AddPlanToUserAction
{
    public static function make(?int $userId = null, string $modalWidth = 'md'): Action
    {
        return Action::make('add_plan_to_user')
            ->label(__('messages.user_plan.actions.add_plan'))
            ->icon('heroicon-o-plus-circle')
            ->color('success')
            ->modalHeading(__('messages.user_plan.actions.add_plan'))
            ->modalSubmitActionLabel(__('messages.user_plan.actions.add_plan'))
            ->schema([
                // Only show user selection if no user ID is provided
                Select::make('user_id')
                    ->label(__('messages.user_plan.fields.user'))
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->placeholder(__('messages.user_plan.placeholders.select_user'))
                    ->visible(fn() => $userId === null)
                    ->default($userId),

                // Hidden field for user ID when provided
                \Filament\Forms\Components\Hidden::make('user_id')
                    ->default($userId)
                    ->visible(fn() => $userId !== null),

                Select::make('plan_id')
                    ->label(__('messages.user_plan.fields.plan'))
                    ->options(Plan::where('is_active', true)->get()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->placeholder(__('messages.user_plan.placeholders.select_plan'))
                    ->helperText(__('messages.user_plan.helpers.plan_selection')),

                Toggle::make('immediate_activation')
                    ->label(__('messages.user_plan.fields.immediate_activation'))
                    ->helperText(__('messages.user_plan.helpers.immediate_activation'))
                    ->default(true),
            ])
            ->modalWidth($modalWidth)
            ->action(function (array $data): void {
                try {
                    // Ensure user_id is set
                    if (!isset($data['user_id']) || empty($data['user_id'])) {
                        throw new \Exception(__('messages.user_plan.errors.user_required'));
                    }

                    // Ensure plan_id is set
                    if (!isset($data['plan_id']) || empty($data['plan_id'])) {
                        throw new \Exception(__('messages.user_plan.errors.plan_required'));
                    }

                    $user = User::findOrFail($data['user_id']);
                    $plan = Plan::findOrFail($data['plan_id']);

                    // Cancel existing active plan by default
                    $user->cancelActivePlan();

                    // Determine start date based on immediate_activation
                    $startDate = ($data['immediate_activation'] ?? true) ? now() : now()->addDay();

                    // Create new user plan
                    $userPlan = $user->userPlans()->create([
                        'plan_id' => $plan->id,
                        'status' => 'active',
                        'starts_at' => $startDate,
                        'ends_at' => $startDate->addMonths($plan->duration_months),
                        'expired_at' => $startDate->addMonths($plan->duration_months),
                        'is_expired' => false,
                    ]);

                    // Send success notification
                    Notification::make()
                        ->title(__('messages.user_plan.notifications.plan_added'))
                        ->body(__('messages.user_plan.notifications.plan_added_body', [
                            'user' => $user->name,
                            'plan' => $plan->name,
                            'duration' => $plan->duration_months . ' ' . __('messages.user_plan.months'),
                        ]))
                        ->success()
                        ->duration(5000)
                        ->send();

                } catch (\Exception $e) {
                    // Send error notification
                    Notification::make()
                        ->title(__('messages.user_plan.notifications.add_error'))
                        ->body(__('messages.user_plan.notifications.add_error_body', ['error' => $e->getMessage()]))
                        ->danger()
                        ->duration(8000)
                        ->send();

                    throw $e;
                }
            })
            ->requiresConfirmation()
            ->modalIcon('heroicon-o-credit-card');
    }
} 