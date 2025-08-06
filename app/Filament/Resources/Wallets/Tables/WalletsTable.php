<?php

namespace App\Filament\Resources\Wallets\Tables;

use App\Filament\Actions\TopupWalletAction;
use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\Vouchers\VoucherResource;
use App\Models\Wallet;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WalletsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('messages.wallet.table.columns.id'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label(__('messages.wallet.table.columns.user'))
                    ->url(fn (Wallet $record): string => UserResource::getUrl('edit', ['record' => $record->user_id]))
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->weight('bold')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('credit')
                    ->label(__('messages.wallet.table.columns.credit'))
                    ->money('LYD')
                    ->color(fn ($state) => $state > 0 ? 'success' : 'gray')
                    ->icon(fn ($state) => $state > 0 ? 'heroicon-o-plus-circle' : null)
                    ->sortable(),
                TextColumn::make('debit')
                    ->label(__('messages.wallet.table.columns.debit'))
                    ->money('LYD')
                    
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'gray')
                    ->icon(fn ($state) => $state > 0 ? 'heroicon-o-minus-circle' : null)
                    ->sortable(),
                TextColumn::make('balance')
                    ->label(__('messages.wallet.table.columns.balance'))
                    ->money('LYD')
                    ->color(fn ($state) => $state >= 0 ? 'success' : 'danger')
                    ->weight('bold')
                    ->sortable(),
                TextColumn::make('voucher.name')
                    ->label(__('messages.wallet.table.columns.voucher'))
                    ->url(fn (Wallet $record): ?string => $record->voucher_id ? VoucherResource::getUrl('edit', ['record' => $record->voucher_id]) : null)
                    ->openUrlInNewTab()
                    ->color('info')
                    ->icon('heroicon-o-ticket')
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('description')
                    ->label(__('messages.wallet.table.columns.description'))
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    })
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('messages.wallet.table.columns.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('messages.wallet.table.columns.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label(__('messages.wallet.table.columns.deleted_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->label(__('messages.wallet.filters.user'))
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('voucher')
                    ->label(__('messages.wallet.filters.voucher'))
                    ->relationship('voucher', 'name')
                    ->searchable()
                    ->preload(),
                TrashedFilter::make(),
            ])
           
           
            ->defaultSort('created_at', 'desc');
    }
}
