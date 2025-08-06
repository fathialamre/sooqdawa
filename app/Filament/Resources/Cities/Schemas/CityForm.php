<?php

namespace App\Filament\Resources\Cities\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                 TextInput::make('name')
                            ->label(__('messages.city.form.fields.name'))
                            ->required()
                            ->maxLength(255),

                        Toggle::make('is_active')
                            ->label(__('messages.city.form.fields.is_active'))
                            ->default(true),
            ])->columns(1);
    }
}
