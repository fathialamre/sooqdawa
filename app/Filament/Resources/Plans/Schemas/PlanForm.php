<?php

namespace App\Filament\Resources\Plans\Schemas;

use App\Models\Plan;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('messages.plan.sections.basic_info'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('messages.plan.fields.name'))
                            ->required()
                            ->maxLength(255)
                            ->unique(Plan::class, 'name', ignoreRecord: true),

                        TextInput::make('price')
                            ->label(__('messages.plan.fields.price'))
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->step(0.01)
                            ->suffix(__('messages.lyd')),

                        TextInput::make('duration_months')
                            ->label(__('messages.plan.fields.duration_months'))
                            ->required()
                            ->integer()
                            ->minValue(1)
                            ->helperText(__('messages.plan.helpers.duration_months')),

                        Textarea::make('description')
                            ->label(__('messages.plan.fields.description'))
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        TextInput::make('number_of_posts')
                            ->label(__('messages.plan.fields.number_of_posts'))
                            ->required()
                            ->integer()
                            ->minValue(0)
                            ->helperText(__('messages.plan.helpers.number_of_posts')),

                        RichEditor::make('feature_posts')
                            ->label(__('messages.plan.fields.feature_posts'))
                            ->columnSpanFull()
                            ->helperText(__('messages.plan.helpers.feature_posts')),

                        Toggle::make('is_active')
                            ->label(__('messages.plan.fields.is_active'))
                            ->default(true)
                            ->helperText(__('messages.plan.helpers.is_active')),
                    ])
                    ->columns(2),

                Section::make(__('messages.plan.sections.media'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('avatar')
                            ->label(__('messages.plan.fields.avatar'))
                            ->collection('avatar')
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('300')
                            ->helperText(__('messages.plan.helpers.avatar')),
                    ]),
            ]);
    }
}