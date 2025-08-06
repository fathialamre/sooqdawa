<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('messages.department.form.section.basic'))
                    ->description(__('messages.department.form.section.basic_description'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('messages.department.form.fields.name'))
                            ->required()
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label(__('messages.department.form.fields.description'))
                            ->rows(3)
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label(__('messages.department.form.fields.is_active'))
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make(__('messages.department.form.section.media'))
                    ->description(__('messages.department.form.section.media_description'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('photo')
                            ->label(__('messages.department.form.fields.photo'))
                            ->collection('default')
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('300')
                            ->helperText(__('messages.department.form.fields.photo_help')),
                    ]),
            ]);
    }
}
