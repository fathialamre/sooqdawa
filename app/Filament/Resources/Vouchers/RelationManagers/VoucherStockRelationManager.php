<?php

namespace App\Filament\Resources\Vouchers\RelationManagers;

use App\Filament\Actions\BulkCreateVoucherStockAction;
use App\Filament\Actions\CreateVoucherStockAction;
use App\Models\VoucherStock;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class VoucherStockRelationManager extends RelationManager
{
    protected static string $relationship = 'voucherStock';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('pin')
            ->heading(__('messages.voucher_stock.relations.title'))
            ->description(__('messages.voucher_stock.relations.description'))
            ->columns([
                TextColumn::make('id')
                    ->label(__('messages.voucher_stock.fields.id'))
                    ->sortable(),

                TextColumn::make('pin')
                    ->label(__('messages.voucher_stock.fields.pin'))
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage(__('messages.voucher_stock.actions.pin_copied'))
                    ->weight('bold')
                    ->fontFamily('mono'),

                ToggleColumn::make('used')
                    ->label(__('messages.voucher_stock.fields.used'))
                    ->sortable()
                    ->disabled(fn($record) => $record->used)
                    ->beforeStateUpdated(function ($record, $state) {
                        if ($state) {
                            // Set used_at timestamp when marking as used
                            $record->used_at = now();
                            $record->save();
                        } else {
                            // Clear used_at timestamp when marking as unused
                            $record->used_at = null;
                            $record->save();
                        }
                    }),

                TextColumn::make('used_at')
                    ->label(__('messages.voucher_stock.fields.used_at'))
                    ->dateTime()
                    ->sortable()
                    ->placeholder('—')
                    ->color(fn($record) => $record->used ? 'danger' : null),

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
                SelectFilter::make('used')
                    ->label(__('messages.voucher_stock.filters.used'))
                    ->options([
                        1 => __('messages.common.yes'),
                        0 => __('messages.common.no'),
                    ]),

                TrashedFilter::make()
                    ->label(__('messages.voucher_stock.filters.trashed')),
            ])
            ->headerActions([
                CreateVoucherStockAction::make($this->getOwnerRecord()->id),
                BulkCreateVoucherStockAction::make($this->getOwnerRecord()->id),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}