<?php

namespace App\Filament\Resources\UserPlans\Tables;

use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\Plans\PlanResource;
use App\Filament\Resources\UserPlans\Actions\CancelPlanAction;
use App\Models\UserPlan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserPlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('messages.user_plan.table.columns.id'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->label(__('messages.user_plan.table.columns.user_name'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->url(fn (UserPlan $record): string => UserResource::getUrl('view', ['record' => $record->user_id]))
                    ->openUrlInNewTab(),

                TextColumn::make('user.email')
                    ->label(__('messages.user_plan.table.columns.user_email'))
                    ->searchable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

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

                Filter::make('active')
                    ->label(__('messages.user_plan.table.filters.active'))
                    ->query(fn (Builder $query): Builder => $query->active()),

                Filter::make('expired')
                    ->label(__('messages.user_plan.table.filters.expired'))
                    ->query(fn (Builder $query): Builder => $query->expired()),

                SelectFilter::make('user_id')
                    ->label(__('messages.user_plan.table.filters.by_user'))
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make(),
                CancelPlanAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
