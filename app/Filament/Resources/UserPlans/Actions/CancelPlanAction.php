<?php

namespace App\Filament\Resources\UserPlans\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;

class CancelPlanAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'cancel_plan';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('messages.user_plan.actions.cancel.label'))
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->requiresConfirmation()
            ->modalHeading(__('messages.user_plan.actions.cancel.modal.title'))
            ->modalDescription(__('messages.user_plan.actions.cancel.modal.description'))
            ->modalSubmitActionLabel(__('messages.user_plan.actions.cancel.modal.confirm'))
            ->modalCancelActionLabel(__('messages.user_plan.actions.cancel.modal.cancel'))
            ->action(function ($record) {
                $record->cancel();
                
                Notification::make()
                    ->title(__('messages.user_plan.actions.cancel.notification.title'))
                    ->body(__('messages.user_plan.actions.cancel.notification.body'))
                    ->success()
                    ->send();
            })
            ->visible(fn ($record) => $record->status === 'active');
    }
} 