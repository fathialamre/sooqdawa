<?php

namespace App\Filament\Resources\OffensiveWords\Schemas;

use App\Models\OffensiveWord;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OffensiveWordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                 TextInput::make('word')
                            ->label(__('messages.offensive_word.fields.word'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label(__('messages.offensive_word.fields.description'))
                            ->rows(3)
                            ->maxLength(500),

                        Select::make('severity')
                            ->label(__('messages.offensive_word.fields.severity'))
                            ->options([
                                'low' => __('messages.offensive_word.severity.low'),
                                'medium' => __('messages.offensive_word.severity.medium'),
                                'high' => __('messages.offensive_word.severity.high'),
                            ])
                            ->required()
                            ->default('medium'),

                        Toggle::make('is_active')
                            ->label(__('messages.offensive_word.fields.is_active'))
                            ->default(true),
            ])
            ->columns(1);
    }
} 