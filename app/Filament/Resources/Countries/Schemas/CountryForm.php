<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                            ->label(__('messages.country.fields.name'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText(__('messages.country.fields.name_helper')),

                        TextInput::make('iso')
                            ->label(__('messages.country.fields.iso'))
                            ->required()
                            ->maxLength(3)
                            ->unique(ignoreRecord: true)
                            ->placeholder('USA, GBR, etc.')
                            ->helperText(__('messages.country.fields.iso_helper')),
            ])->columns(1);
    }
}