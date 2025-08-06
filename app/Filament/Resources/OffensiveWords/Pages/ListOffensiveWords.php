<?php

namespace App\Filament\Resources\OffensiveWords\Pages;

use App\Filament\Resources\OffensiveWords\OffensiveWordResource;
use Filament\Resources\Pages\ListRecords;

class ListOffensiveWords extends ListRecords
{
    protected static string $resource = OffensiveWordResource::class;
} 