<?php

namespace App\Filament\Resources\VoucherStocks;

use App\Filament\Resources\VoucherStocks\Pages\CreateVoucherStock;
use App\Filament\Resources\VoucherStocks\Pages\EditVoucherStock;
use App\Filament\Resources\VoucherStocks\Pages\ListVoucherStocks;
use App\Filament\Resources\VoucherStocks\Pages\ViewVoucherStock;
use App\Filament\Resources\VoucherStocks\Schemas\VoucherStockForm;
use App\Filament\Resources\VoucherStocks\Tables\VoucherStocksTable;
use App\Models\VoucherStock;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VoucherStockResource extends Resource
{
    protected static ?string $model = VoucherStock::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CreditCard;

    protected static ?string $recordTitleAttribute = 'pin';

    public static function getLabel(): string
    {
        return __('messages.voucher_stock.navigation.label');
    }

    public static function getPluralLabel(): string
    {
        return __('messages.voucher_stock.navigation.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('messages.voucher_stock.navigation.group');
    }

    
    public static function form(Schema $schema): Schema
    {
        return VoucherStockForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VoucherStocksTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVoucherStocks::route('/'),
        ];
    }
} 