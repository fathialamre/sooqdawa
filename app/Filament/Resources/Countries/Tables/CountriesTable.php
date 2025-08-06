<?php

namespace App\Filament\Resources\Countries\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class CountriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('messages.country.table.columns.id'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('messages.country.table.columns.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('iso')
                    ->label(__('messages.country.table.columns.iso'))
                    ->searchable()
                    ->sortable()
                    ->badge(),

                TextColumn::make('users_count')
                    ->label(__('messages.country.table.columns.users_count'))
                    ->counts('users')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('messages.common.table.columns.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('messages.common.table.columns.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('has_users')
                    ->label(__('messages.country.table.filters.has_users'))
                    ->options([
                        'with_users' => __('messages.country.table.filters.with_users'),
                        'without_users' => __('messages.country.table.filters.without_users'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value'] ?? null) {
                            'with_users' => $query->has('users'),
                            'without_users' => $query->doesntHave('users'),
                            default => $query,
                        };
                    }),
            ])
            ->recordActions([
                EditAction::make()
                ->modalWidth('md'),
            ])
            ->headerActions([
                CreateAction::make()
                ->modalWidth('md'),
            ])
            ->defaultSort('name')
            ->emptyStateHeading(__('messages.country.table.empty.heading'))
            ->emptyStateDescription(__('messages.country.table.empty.description'));
    }
}