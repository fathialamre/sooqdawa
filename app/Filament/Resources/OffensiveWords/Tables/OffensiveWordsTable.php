<?php

namespace App\Filament\Resources\OffensiveWords\Tables;

use App\Models\OffensiveWord;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;

class OffensiveWordsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('messages.offensive_word.table.columns.id'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('word')
                    ->label(__('messages.offensive_word.table.columns.word'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('description')
                    ->label(__('messages.offensive_word.table.columns.description'))
                    ->limit(50)
                    ->searchable()
                    ->wrap()
                ,

                TextColumn::make('severity')
                    ->badge()
                    ->label(__('messages.offensive_word.table.columns.severity'))
                    ->colors([
                        'danger' => 'high',
                        'warning' => 'medium',
                        'info' => 'low',
                    ])
                    ->formatStateUsing(fn(string $state): string => __('messages.offensive_word.severity.' . $state)),

                TextColumn::make('is_active')
                    ->badge()
                    ->label(__('messages.offensive_word.table.columns.is_active'))
                    ->colors([
                        'success' => true,
                        'gray' => false,
                    ])
                    ->formatStateUsing(fn(bool $state): string => $state
                        ? __('messages.offensive_word.status.active')
                        : __('messages.offensive_word.status.inactive')),

                TextColumn::make('created_at')
                    ->label(__('messages.offensive_word.table.columns.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('severity')
                    ->label(__('messages.offensive_word.table.filters.severity'))
                    ->options([
                        'high' => __('messages.offensive_word.severity.high'),
                        'medium' => __('messages.offensive_word.severity.medium'),
                        'low' => __('messages.offensive_word.severity.low'),
                    ]),

                TernaryFilter::make('is_active')
                    ->label(__('messages.offensive_word.table.filters.is_active'))
                    ->placeholder('All')
                    ->trueLabel(__('messages.offensive_word.status.active'))
                    ->falseLabel(__('messages.offensive_word.status.inactive')),
            ])
            ->headerActions([
                CreateAction::make()
                    ->modalWidth('md')
                    ->modalHeading(__('messages.offensive_word.actions.create'))
                    ->modalDescription(__('messages.offensive_word.modals.create.description')),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth('md')
                    ->modalHeading(__('messages.offensive_word.actions.edit'))
                    ->modalDescription(__('messages.offensive_word.modals.edit.description')),

                Action::make('activate')
                    ->label(__('messages.offensive_word.status.active'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->activate())
                    ->visible(fn($record) => !$record->isActive()),

                Action::make('deactivate')
                    ->label(__('messages.offensive_word.status.inactive'))
                    ->icon('heroicon-o-x-circle')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->deactivate())
                    ->visible(fn($record) => $record->isActive()),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('activate')
                        ->label(__('messages.offensive_word.status.active'))
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each(fn($record) => $record->activate())),

                    BulkAction::make('deactivate')
                        ->label(__('messages.offensive_word.status.inactive'))
                        ->icon('heroicon-o-x-circle')
                        ->color('gray')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each(fn($record) => $record->deactivate())),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}