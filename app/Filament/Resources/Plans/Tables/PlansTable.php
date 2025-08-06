<?php

namespace App\Filament\Resources\Plans\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class PlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar')
                    ->collection('avatar')
                    ->label(__('messages.plan.table.columns.avatar')),

                TextColumn::make('name')
                    ->label(__('messages.plan.table.columns.name'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('price')
                    ->label(__('messages.plan.table.columns.price'))
                    ->money('LYD', )
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),

                TextColumn::make('duration_months')
                    ->label(__('messages.plan.table.columns.duration_months'))
                    ->suffix(' ' . __('messages.plan.table.columns.months'))
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('description')
                    ->label(__('messages.plan.table.columns.description'))
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('number_of_posts')
                    ->label(__('messages.plan.table.columns.number_of_posts'))
                    ->sortable()
                    ->badge()
                    ->color('warning'),

                TextColumn::make('feature_posts')
                    ->label(__('messages.plan.table.columns.feature_posts'))
                    ->limit(30)
                    ->html()
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen(strip_tags($state)) <= 30) {
                            return null;
                        }
                        return strip_tags($state);
                    }),

                TextColumn::make('activeUserPlans_count')
                    ->label(__('messages.plan.table.columns.active_subscriptions'))
                    ->counts('activeUserPlans')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label(__('messages.plan.table.columns.is_active'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('messages.plan.table.columns.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('messages.plan.table.columns.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label(__('messages.plan.filters.is_active'))
                    ->options([
                        1 => __('messages.common.active'),
                        0 => __('messages.common.inactive'),
                    ])
                    ->default(1),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}