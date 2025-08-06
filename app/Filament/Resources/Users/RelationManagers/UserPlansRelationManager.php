<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Plans\PlanResource;
use App\Models\UserPlan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UserPlansRelationManager extends RelationManager
{
    protected static string $relationship = 'userPlans';

    public static function getTitle($owner, string $pageClass): string
    {
        return __('messages.user_plan.navigation.plural');
    }

    public static function getModelLabel(): string
    {
        return __('messages.user_plan.navigation.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.user_plan.navigation.plural');
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('plan.name')
            ->columns([
                TextColumn::make('plan.name')
                    ->label(__('messages.user_plan.table.columns.plan_name'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->url(fn (UserPlan $record): string => PlanResource::getUrl('view', ['record' => $record->plan_id]))
                    ->openUrlInNewTab(),

                TextColumn::make('plan.price')
                    ->label(__('messages.user_plan.table.columns.plan_price'))
                    ->money('LYD')
                    ->sortable()
                    ->color('success'),

                BadgeColumn::make('status')
                    ->label(__('messages.user_plan.table.columns.status'))
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'cancelled' => 'warning',
                        'expired' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => __('messages.user_plan.table.statuses.active'),
                        'cancelled' => __('messages.user_plan.table.statuses.cancelled'),
                        'expired' => __('messages.user_plan.table.statuses.expired'),
                        default => $state,
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('starts_at')
                    ->label(__('messages.user_plan.table.columns.starts_at'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('ends_at')
                    ->label(__('messages.user_plan.table.columns.ends_at'))
                    ->dateTime()
                    ->sortable()
                    ->color(fn ($record) => $record->ends_at && $record->ends_at < now() ? 'danger' : null),

                TextColumn::make('expired_at')
                    ->label(__('messages.user_plan.table.columns.expired_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('cancelled_at')
                    ->label(__('messages.user_plan.table.columns.cancelled_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label(__('messages.user_plan.table.columns.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('messages.user_plan.table.filters.status'))
                    ->options([
                        'active' => __('messages.user_plan.table.statuses.active'),
                        'cancelled' => __('messages.user_plan.table.statuses.cancelled'),
                        'expired' => __('messages.user_plan.table.statuses.expired'),
                    ]),

                SelectFilter::make('plan_id')
                    ->label(__('messages.user_plan.table.filters.by_plan'))
                    ->relationship('plan', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Check if user already has an active plan
                        $hasActivePlan = $this->getOwnerRecord()
                            ->userPlans()
                            ->where('status', 'active')
                            ->exists();

                        if ($hasActivePlan && ($data['status'] ?? 'active') === 'active') {
                            // Cancel existing active plan
                            $this->getOwnerRecord()
                                ->userPlans()
                                ->where('status', 'active')
                                ->update([
                                    'status' => 'cancelled',
                                    'cancelled_at' => now(),
                                ]);
                        }

                        return $data;
                    })
                    ->after(function (UserPlan $record) {
                        // Ensure only one active plan per user
                        if ($record->status === 'active') {
                            $record->user->userPlans()
                                ->where('status', 'active')
                                ->where('id', '!=', $record->id)
                                ->update([
                                    'status' => 'cancelled',
                                    'cancelled_at' => now(),
                                ]);
                        }
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn (UserPlan $record): string => PlanResource::getUrl('view', ['record' => $record->plan_id]))
                    ->openUrlInNewTab(),
                EditAction::make()
                    ->mutateFormDataUsing(function (array $data, UserPlan $record): array {
                        // Check if user already has an active plan
                        $hasActivePlan = $record->user
                            ->userPlans()
                            ->where('status', 'active')
                            ->where('id', '!=', $record->id)
                            ->exists();

                        if ($hasActivePlan && ($data['status'] ?? 'active') === 'active') {
                            // Cancel existing active plan
                            $record->user
                                ->userPlans()
                                ->where('status', 'active')
                                ->where('id', '!=', $record->id)
                                ->update([
                                    'status' => 'cancelled',
                                    'cancelled_at' => now(),
                                ]);
                        }

                        return $data;
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
} 