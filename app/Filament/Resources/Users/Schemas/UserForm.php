<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\Country;
use App\Models\User;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;


class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('messages.user.sections.basic_info'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('messages.user.fields.name'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label(__('messages.user.fields.email'))
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(User::class, 'email', ignoreRecord: true),

                        TextInput::make('phone')
                            ->label(__('messages.user.fields.phone'))
                            ->tel()
                            ->required()
                            ->maxLength(255)
                            ->unique(User::class, 'phone', ignoreRecord: true),


                        Select::make('type')
                            ->label(__('messages.user.fields.type'))
                            ->options([
                                'admin' => __('messages.user.types.admin'),
                                'customer' => __('messages.user.types.customer'),
                                'company' => __('messages.user.types.company'),
                            ])
                            ->required()
                            ->default('customer'),

                        Select::make('country_id')
                            ->label(__('messages.user.fields.country'))
                            ->relationship('country', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        Toggle::make('is_active')
                            ->label(__('messages.user.fields.is_active'))
                            ->default(true),
                    ])
                    ->columns(2),



                Section::make(__('messages.user.sections.media'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('avatar')
                            ->label(__('messages.user.fields.avatar'))
                            ->collection('avatar'),
                    ]),

                Section::make(__('messages.user.sections.notifications'))
                    ->schema([
                        TextInput::make('fcm_token')
                            ->label(__('messages.user.fields.fcm_token'))
                            ->maxLength(255)
                            ->nullable()
                            ->helperText(__('messages.user.helpers.fcm_token')),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}
