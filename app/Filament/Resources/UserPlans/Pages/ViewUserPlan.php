<?php

namespace App\Filament\Resources\UserPlans\Pages;

use App\Filament\Resources\UserPlans\UserPlanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUserPlan extends ViewRecord
{
    protected static string $resource = UserPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
} 