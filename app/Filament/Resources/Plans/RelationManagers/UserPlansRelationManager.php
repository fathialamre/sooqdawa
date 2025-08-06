<?php

namespace App\Filament\Resources\Plans\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UserPlansRelationManager extends RelationManager
{
    protected static string $relationship = 'userPlans';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->heading(__('messages.plan.relations.user_plans.title'))
            ->description(__('messages.plan.relations.user_plans.description'))
            ->columns([
                

                TextColumn::make('user.name')
                    ->label(__('messages.plan.relations.user_plans.user'))
                    ->searchable()
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->sortable()
                    ->weight('bold')
                    ->color(color: 'primary')
                    ->url(function ($record) {
                        return route('filament.admin.resources.users.view', $record->user);
                    })
                    ->openUrlInNewTab(),

                TextColumn::make('user.email')
                    ->label(__('messages.plan.relations.user_plans.user_email'))
                    ->searchable()
                    ->copyable()
                    ->copyMessage(__('messages.user.infolist.email_copied')),

                TextColumn::make('status')
                    ->label(__('messages.plan.relations.user_plans.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'cancelled' => 'warning',
                        'expired' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => __('messages.plan.relations.user_plans.statuses.active'),
                        'cancelled' => __('messages.plan.relations.user_plans.statuses.cancelled'),
                        'expired' => __('messages.plan.relations.user_plans.statuses.expired'),
                        default => $state,
                    })
                    ->sortable(),

                TextColumn::make('starts_at')
                    ->label(__('messages.plan.relations.user_plans.starts_at'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('ends_at')
                    ->label(__('messages.plan.relations.user_plans.ends_at'))
                    ->dateTime()
                    ->sortable()
                    ->color(function ($record) {
                        if ($record->ends_at && $record->ends_at < now()) {
                            return 'danger';
                        }
                        return null;
                    }),

                TextColumn::make('cancelled_at')
                    ->label(__('messages.plan.relations.user_plans.cancelled_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label(__('messages.plan.relations.user_plans.subscribed_at'))
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('messages.plan.relations.user_plans.filters.status'))
                    ->options([
                        'active' => __('messages.plan.relations.user_plans.statuses.active'),
                        'cancelled' => __('messages.plan.relations.user_plans.statuses.cancelled'),
                        'expired' => __('messages.plan.relations.user_plans.statuses.expired'),
                    ])
                    ->default('active'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(function ($record) {
                        return route('filament.admin.resources.users.view', $record->user);
                    })
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}