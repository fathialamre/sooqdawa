<?php

namespace App\Filament\Resources\VoucherStocks\Pages;

use App\Filament\Actions\BulkCreateVoucherStockAction;
use App\Filament\Actions\CreateVoucherStockAction;
use App\Filament\Resources\VoucherStocks\VoucherStockResource;
use Filament\Resources\Pages\ListRecords;

class ListVoucherStocks extends ListRecords
{
    protected static string $resource = VoucherStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateVoucherStockAction::make(),
            BulkCreateVoucherStockAction::make(),
        ];
    }
} 