<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Actions\AddPlanToUserAction;
use App\Filament\Actions\ChangePasswordAction;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ChangePasswordAction::make('sm'),
            AddPlanToUserAction::make($this->record->id),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
