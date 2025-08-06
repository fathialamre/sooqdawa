<?php

namespace App\Filament\Resources\UserPlans\Pages;

use App\Filament\Resources\UserPlans\UserPlanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserPlans extends ListRecords
{
    protected static string $resource = UserPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalHeading(__('messages.user_plan.actions.create_modal.title'))
                ->modalDescription(__('messages.user_plan.actions.create_modal.description'))
                ->modalSubmitActionLabel(__('messages.user_plan.actions.create_modal.submit'))
                ->modalCancelActionLabel(__('messages.user_plan.actions.create_modal.cancel')),
        ];
    }
}
