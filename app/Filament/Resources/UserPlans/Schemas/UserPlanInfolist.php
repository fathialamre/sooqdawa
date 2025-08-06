<?php

namespace App\Filament\Resources\UserPlans\Schemas;

use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\Plans\PlanResource;
use App\Filament\Resources\Users\UserResource;

class UserPlanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('messages.user_plan.infolist.user_information'))
                    ->schema([
                        Grid::make(columns: 2)
                            ->schema([
                                TextEntry::make('user.name')
                                    ->url(fn($record) => UserResource::getUrl('view', ['record' => $record->user_id]))
                                    ->openUrlInNewTab()
                                    ->color('primary')
                                    ->icon('heroicon-o-arrow-top-right-on-square')
                                    ->label(__('messages.user_plan.infolist.user_name'))
                                    ->weight('bold'),
                                TextEntry::make('user.email')
                                    ->label(__('messages.user_plan.infolist.user_email'))
                                    ->copyable(),
                                TextEntry::make('user.phone')
                                    ->label(__('messages.user_plan.infolist.user_phone'))
                                    ->copyable(),
                                TextEntry::make('user.country.name')
                                    ->label(__('messages.user_plan.infolist.user_country')),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make(__('messages.user_plan.infolist.plan_information'))
                    ->schema([
                        Grid::make(columns: 2)
                            ->schema([
                                TextEntry::make('plan.name')
                                    ->url(fn($record) => PlanResource::getUrl('view', ['record' => $record->plan_id]))
                                    ->openUrlInNewTab()
                                    ->color('primary')
                                    ->icon('heroicon-o-arrow-top-right-on-square')
                                    ->label(__('messages.user_plan.infolist.plan_name'))
                                    ->weight('bold'),
                                TextEntry::make('plan.price')
                                    ->label(__('messages.user_plan.infolist.plan_price'))
                                    ->money('LYD')
                                    ->color('success'),
                                TextEntry::make('plan.duration_months')
                                    ->label(__('messages.user_plan.infolist.plan_duration'))
                                    ->suffix(' ' . __('messages.user_plan.infolist.months')),
                                TextEntry::make('plan.number_of_posts')
                                    ->label(__('messages.user_plan.infolist.plan_posts')),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make(__('messages.user_plan.infolist.subscription_details'))
                    ->schema([
                        Grid::make(columns: 2)
                            ->schema([
                                TextEntry::make('status')
                                    ->label(__('messages.user_plan.infolist.status'))
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'active' => 'success',
                                        'cancelled' => 'warning',
                                        'expired' => 'danger',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn (string $state): string => match ($state) {
                                        'active' => __('messages.user_plan.infolist.statuses.active'),
                                        'cancelled' => __('messages.user_plan.infolist.statuses.cancelled'),
                                        'expired' => __('messages.user_plan.infolist.statuses.expired'),
                                        default => $state,
                                    }),
                                TextEntry::make('is_expired')
                                    ->icon(fn (bool $state): string => $state ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                                    ->label(__('messages.user_plan.infolist.is_expired'))
                                    ->iconColor(fn (bool $state): string => $state ? 'danger' : 'success')
                                    ->formatStateUsing(fn (bool $state): string => $state ? __('messages.user_plan.infolist.is_expired_true') : __('messages.user_plan.infolist.is_expired_false')),
                                TextEntry::make('starts_at')
                                    ->label(__('messages.user_plan.infolist.starts_at'))
                                    ->dateTime(),
                                TextEntry::make('ends_at')
                                    ->label(__('messages.user_plan.infolist.ends_at'))
                                    ->dateTime()
                                    ->color(fn ($record) => $record->ends_at && $record->ends_at < now() ? 'danger' : null),
                                TextEntry::make('expired_at')
                                    ->label(__('messages.user_plan.infolist.expired_at'))
                                    ->dateTime()
                                    ->visible(fn ($record) => $record->expired_at),
                                TextEntry::make('cancelled_at')
                                    ->label(__('messages.user_plan.infolist.cancelled_at'))
                                    ->dateTime()
                                    ->visible(fn ($record) => $record->cancelled_at),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make(__('messages.user_plan.infolist.timestamps'))
                    ->schema([
                        Grid::make(columns: 2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label(__('messages.user_plan.infolist.created_at'))
                                    ->dateTime(),
                                TextEntry::make('updated_at')
                                    ->label(__('messages.user_plan.infolist.updated_at'))
                                    ->dateTime(),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->collapsible(),
            ]);
    }
} 