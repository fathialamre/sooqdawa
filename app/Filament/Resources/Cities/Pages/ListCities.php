<?php

namespace App\Filament\Resources\Cities\Pages;

use App\Filament\Resources\Cities\CityResource;
use Filament\Resources\Pages\ListRecords;

class ListCities extends ListRecords
{
    protected static string $resource = CityResource::class;

    public function getTitle(): string
    {
        return __('messages.city.pages.list.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
