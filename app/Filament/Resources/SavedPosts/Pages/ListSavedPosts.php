<?php

namespace App\Filament\Resources\SavedPosts\Pages;

use App\Filament\Resources\SavedPosts\SavedPostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSavedPosts extends ListRecords
{
    protected static string $resource = SavedPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
