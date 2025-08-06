<?php

namespace App\Filament\Resources\Wallets\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class WalletForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('messages.wallet.form.section.basic'))
                    ->description(__('messages.wallet.form.section.basic_description'))
                    ->schema([
                        Select::make('user_id')
                            ->label(__('messages.wallet.fields.user'))
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('voucher_id')
                            ->label(__('messages.wallet.fields.voucher'))
                            ->relationship('voucher', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder(__('messages.wallet.fields.voucher_placeholder')),
                    ])
                    ->columns(2),

                Section::make(__('messages.wallet.form.section.transaction'))
                    ->description(__('messages.wallet.form.section.transaction_description'))
                    ->schema([
                        TextInput::make('credit')
                            ->label(__('messages.wallet.fields.credit'))
                            ->numeric()
                            ->default(0)
                            ->step(0.01)
                            ->prefix('$')
                            ->minValue(0),
                        TextInput::make('debit')
                            ->label(__('messages.wallet.fields.debit'))
                            ->numeric()
                            ->default(0)
                            ->step(0.01)
                            ->prefix('$')
                            ->minValue(0),
                        TextInput::make('balance')
                            ->label(__('messages.wallet.fields.balance'))
                            ->numeric()
                            ->default(0)
                            ->step(0.01)
                            ->prefix('$')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->columns(3),

                Section::make(__('messages.wallet.form.section.details'))
                    ->description(__('messages.wallet.form.section.details_description'))
                    ->schema([
                        Textarea::make('description')
                            ->label(__('messages.wallet.fields.description'))
                            ->placeholder(__('messages.wallet.fields.description_placeholder'))
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
