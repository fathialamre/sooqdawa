<?php

namespace App\Filament\Resources\VoucherStocks\Schemas;

use App\Models\Voucher;
use App\Models\VoucherStock;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class VoucherStockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('messages.voucher_stock.form.section.basic'))
                    ->description(__('messages.voucher_stock.form.section.basic_description'))
                    ->icon('heroicon-o-credit-card')
                    ->schema([
                        Select::make('voucher_id')
                            ->label(__('messages.voucher_stock.fields.voucher'))
                            ->options(Voucher::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->placeholder(__('messages.voucher_stock.placeholders.select_voucher')),

                        TextInput::make('pin')
                            ->label(__('messages.voucher_stock.fields.pin'))
                            ->helperText(__('messages.voucher_stock.helpers.pin'))
                            ->default(fn() => VoucherStock::generateUniquePin())
                            ->required()
                            ->unique(VoucherStock::class, 'pin', ignoreRecord: true)
                            ->maxLength(12)
                            ->minLength(12)
                            ->fontFamily('mono'),

                        Toggle::make('used')
                            ->label(__('messages.voucher_stock.fields.used'))
                            ->default(false)
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state) {
                                if (!$state) {
                                    $set('used_at', null);
                                }
                            }),

                        DateTimePicker::make('used_at')
                            ->label(__('messages.voucher_stock.fields.used_at'))
                            ->visible(fn(Get $get) => $get('used'))
                            ->default(now())
                            ->required(fn(Get $get) => $get('used')),
                    ])
                    ->columns(2),
            ]);
    }
} 