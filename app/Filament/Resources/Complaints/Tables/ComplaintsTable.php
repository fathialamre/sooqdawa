<?php

namespace App\Filament\Resources\Complaints\Tables;

use App\Models\Complaint;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\Users\UserResource;

class ComplaintsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('messages.complaint.table.columns.id'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('body')
                    ->label(__('messages.complaint.table.columns.body'))
                    ->limit(100)
                    ->searchable()
                    ->wrap(),

                TextColumn::make('user.name')
                    ->description(fn (Complaint $record): string => $record->user->email)
                    ->url(fn (Complaint $record): string => UserResource::getUrl('view', ['record' => $record->user_id]))
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->label(__('messages.complaint.table.columns.user'))
                    ->searchable()
                    ->sortable(),


                BadgeColumn::make('status')
                    ->label(__('messages.complaint.table.columns.status'))
                    ->colors([
                        'warning' => 'open',
                        'success' => 'resolved',
                    ])
                    ->formatStateUsing(fn (string $state): string => __('messages.complaint.status.' . $state)),

                TextColumn::make('created_at')
                    ->label(__('messages.complaint.table.columns.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('messages.complaint.table.filters.status'))
                    ->options([
                        'open' => __('messages.complaint.table.filters.open'),
                        'resolved' => __('messages.complaint.table.filters.resolved'),
                    ]),
            ])
            ->actions([
                Action::make('mark_resolved')
                    ->label(__('messages.complaint.table.actions.mark_resolved'))
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->markAsResolved())
                    ->visible(fn ($record) => $record->isOpen()),

                Action::make('mark_open')
                    ->label(__('messages.complaint.table.actions.mark_open'))
                    ->icon('heroicon-o-exclamation-triangle')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->markAsOpen())
                    ->visible(fn ($record) => $record->isResolved()),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('mark_resolved')
                        ->label(__('messages.complaint.table.actions.mark_resolved'))
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each(fn ($record) => $record->markAsResolved())),

                    BulkAction::make('mark_open')
                        ->label(__('messages.complaint.table.actions.mark_open'))
                        ->icon('heroicon-o-exclamation-triangle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each(fn ($record) => $record->markAsOpen())),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
} 