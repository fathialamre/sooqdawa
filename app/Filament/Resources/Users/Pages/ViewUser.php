<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Actions\AddPlanToUserAction;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            AddPlanToUserAction::make($this->record->id),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('messages.user.pages.view.title', ['name' => $this->record->name]);
    }
}