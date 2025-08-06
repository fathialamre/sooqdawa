<?php

namespace App\Filament\Resources\Wallets\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Actions\TopupWalletAction;
use App\Filament\Resources\Wallets\WalletResource;

class ListWallets extends ListRecords
{
    protected static string $resource = WalletResource::class;

    protected function getHeaderActions(): array
    {
        return [
             TopupWalletAction::make(),
        ];
    }
}
