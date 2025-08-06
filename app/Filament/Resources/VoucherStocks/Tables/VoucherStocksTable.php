<?php

namespace App\Filament\Resources\VoucherStocks\Tables;

use App\Filament\Actions\BulkCreateVoucherStockAction;
use App\Filament\Actions\CreateVoucherStockAction;
use App\Models\VoucherStock;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class VoucherStocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('pin')
            ->heading(__('messages.voucher_stock.table.heading'))
            ->description(__('messages.voucher_stock.table.description'))
            ->columns([
                TextColumn::make('id')
                    ->label(__('messages.voucher_stock.fields.id'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('voucher.name')
                    ->label(__('messages.voucher_stock.fields.voucher'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('pin')
                    ->label(__('messages.voucher_stock.fields.pin'))
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage(__('messages.voucher_stock.actions.pin_copied'))
                    ->weight('bold')
                    ->fontFamily('mono')
                    ->badge()
                    ->color('success'),

                ToggleColumn::make('used')
                    ->label(__('messages.voucher_stock.fields.used'))
                    ->sortable()
                    ->disabled(fn($record) => $record->used)
                    ->beforeStateUpdated(function ($record, $state) {
                        if ($state) {
                            $record->used_at = now();
                            $record->save();
                        } else {
                            $record->used_at = null;
                            $record->save();
                        }
                    }),

                TextColumn::make('used_at')
                    ->label(__('messages.voucher_stock.fields.used_at'))
                    ->dateTime()
                    ->sortable()
                    ->placeholder('—')
                    ->color(fn($record) => $record->used ? 'danger' : null)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label(__('messages.voucher_stock.fields.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('messages.voucher_stock.fields.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->label(__('messages.voucher_stock.fields.deleted_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('voucher_id')
                    ->label(__('messages.voucher_stock.fields.voucher'))
                    ->relationship('voucher', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('used')
                    ->label(__('messages.voucher_stock.filters.used'))
                    ->options([
                        1 => __('messages.common.yes'),
                        0 => __('messages.common.no'),
                    ]),

                TrashedFilter::make()
                    ->label(__('messages.voucher_stock.filters.trashed')),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label(__('messages.voucher_stock.actions.view')),
                EditAction::make()
                    ->label(__('messages.voucher_stock.actions.edit')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
} 