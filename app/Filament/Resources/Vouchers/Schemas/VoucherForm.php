<?php

namespace App\Filament\Resources\Vouchers\Schemas;

use App\Models\Voucher;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VoucherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('messages.voucher.sections.basic_info'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('messages.voucher.fields.name'))
                            ->helperText(__('messages.voucher.helpers.name'))
                            ->required()
                            ->unique(Voucher::class, 'name', ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('price')
                            ->label(__('messages.voucher.fields.price'))
                            ->helperText(__('messages.voucher.helpers.price'))
                            ->required()
                            ->numeric()
                            ->suffix(__('messages.lyd'))
                            ->minValue(0)
                            ->step(0.01),

                        Toggle::make('is_active')
                            ->label(__('messages.voucher.fields.is_active'))
                            ->helperText(__('messages.voucher.helpers.is_active'))
                            ->default(true),
                    ])
                    ->columns(2),

                Section::make(__('messages.voucher.sections.media'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('avatar')
                            ->label(__('messages.voucher.fields.avatar'))
                            ->collection('avatar')
                            ->image()
                            ->imageEditor()
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('300')
                            ->imageResizeTargetHeight('300')
                            ->helperText(__('messages.voucher.helpers.avatar')),
                    ]),
            ]);
    }
}