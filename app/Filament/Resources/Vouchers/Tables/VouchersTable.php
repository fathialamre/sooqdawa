<?php

namespace App\Filament\Resources\Vouchers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class VouchersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar_url')
                    ->label(__('messages.voucher.table.columns.avatar'))
                    ->circular()
                    ->defaultImageUrl(function () {
                        return 'https://ui-avatars.com/api/?name=Voucher&color=7F9CF5&background=EBF4FF';
                    }),

                TextColumn::make('name')
                    ->label(__('messages.voucher.table.columns.name'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('price')
                    ->label(__('messages.voucher.table.columns.price'))
                    ->money('LYD', locale: 'en')
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),

                TextColumn::make('total_stock')
                    ->label(__('messages.voucher.table.columns.total_stock'))
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('available_stock')
                    ->label(__('messages.voucher.table.columns.available_stock'))
                    ->badge()
                    ->color('success')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label(__('messages.voucher.table.columns.is_active'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('messages.voucher.table.columns.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('messages.voucher.table.columns.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->label(__('messages.voucher.table.columns.deleted_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label(__('messages.voucher.filters.is_active'))
                    ->options([
                        1 => __('messages.common.yes'),
                        0 => __('messages.common.no'),
                    ]),

                TrashedFilter::make()
                    ->label(__('messages.voucher.filters.trashed')),
            ])
            ->recordActions([
                EditAction::make(),
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