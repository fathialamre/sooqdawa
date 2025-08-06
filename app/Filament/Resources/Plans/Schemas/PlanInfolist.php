<?php

namespace App\Filament\Resources\Plans\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Main information section
                Section::make(__('messages.plan.sections.basic_info'))
                    ->schema([
                        Grid::make(columns: 3)
                            ->schema([
                                // Left column - Plan image and main details
                                Grid::make(1)
                                    ->schema([
                                        SpatieMediaLibraryImageEntry::make('avatar')
                                            ->label(__('messages.plan.fields.avatar'))
                                            ->collection('avatar')
                                            ->circular()
                                            ->size(150)
                                            ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name ?? 'Plan') . '&color=7F9CF5&background=EBF4FF')
                                            ->hiddenLabel(),

                                        TextEntry::make('name')
                                            ->label(__('messages.plan.fields.name'))
                                            ->size('lg')
                                            ->weight('bold')
                                            ->color('primary')
                                            ->icon('heroicon-o-rectangle-stack'),
                                    ])
                                    ->columnSpan(1),

                                // Middle column - Plan details
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('price')
                                            ->label(__('messages.plan.fields.price'))
                                            ->money('LYD', locale: 'en')
                                            ->weight('bold')
                                            ->color('success')
                                            ->icon('heroicon-o-banknotes'),

                                        TextEntry::make('duration_months')
                                            ->label(__('messages.plan.fields.duration_months'))
                                            ->suffix(' ' . __('messages.plan.fields.months'))
                                            ->badge()
                                            ->color('info')
                                            ->icon('heroicon-o-clock'),

                                        TextEntry::make('description')
                                            ->label(__('messages.plan.fields.description'))
                                            ->limit(100)
                                            ->tooltip(fn ($state) => strlen($state) > 100 ? $state : null)
                                            ->icon('heroicon-o-document-text')
                                            ->columnSpanFull(),

                                        TextEntry::make('number_of_posts')
                                            ->label(__('messages.plan.fields.number_of_posts'))
                                            ->badge()
                                            ->color('warning')
                                            ->icon('heroicon-o-document'),

                                        TextEntry::make('feature_posts')
                                            ->label(__('messages.plan.fields.feature_posts'))
                                            ->html()
                                            ->icon('heroicon-o-star')
                                            ->columnSpanFull(),

                                        TextEntry::make('userPlans_count')
                                            ->label(__('messages.plan.fields.total_subscriptions'))
                                            ->badge()
                                            ->color('primary')
                                            ->icon('heroicon-o-users'),

                                        TextEntry::make('activeUserPlans_count')
                                            ->label(__('messages.plan.fields.active_subscriptions'))
                                            ->badge()
                                            ->color('success')
                                            ->icon('heroicon-o-user-group'),
                                    ])
                                    ->columnSpan(1),

                                // Right column - Status and timestamps
                                Grid::make(1)
                                    ->schema([
                                        IconEntry::make('is_active')
                                            ->label(__('messages.plan.fields.is_active'))
                                            ->boolean()
                                            ->trueIcon('heroicon-o-check-circle')
                                            ->falseIcon('heroicon-o-x-circle')
                                            ->trueColor('success')
                                            ->falseColor('danger'),

                                        TextEntry::make('created_at')
                                            ->label(__('messages.plan.infolist.created_at'))
                                            ->dateTime()
                                            ->since()
                                            ->icon('heroicon-o-calendar-days'),

                                        TextEntry::make('updated_at')
                                            ->label(__('messages.plan.infolist.updated_at'))
                                            ->dateTime()
                                            ->since()
                                            ->icon('heroicon-o-pencil-square'),

                                        TextEntry::make('id')
                                            ->label('Plan ID')
                                            ->copyable()
                                            ->copyMessage('Plan ID copied!')
                                            ->copyMessageDuration(1500)
                                            ->icon('heroicon-o-hashtag')
                                            ->badge()
                                            ->color('gray'),
                                    ])
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}