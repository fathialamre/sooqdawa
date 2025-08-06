<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Main information section
                Section::make(__('messages.user.sections.basic_info'))
                    ->schema([
                        Grid::make(columns: 3)
                            ->schema([
                                // Left column - Main details
                                Grid::make(1)
                                    ->schema([
                                        SpatieMediaLibraryImageEntry::make('avatar')
                                            ->label(__('messages.user.fields.avatar'))
                                            ->collection('avatar')
                                            ->circular()
                                            ->size(150)
                                            ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name ?? 'User') . '&color=7F9CF5&background=EBF4FF')
                                            ->hiddenLabel(),

                                        TextEntry::make('name')
                                            ->label(__('messages.user.fields.name'))
                                            ->size('lg')
                                            ->weight('bold')
                                            ->color('primary')
                                            ->icon('heroicon-o-user'),
                                    ])
                                    ->columnSpan(1),

                                // Middle column - Contact info
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('email')
                                            ->label(__('messages.user.fields.email'))
                                            ->copyable()
                                            ->copyMessage(__('messages.user.infolist.email_copied'))
                                            ->copyMessageDuration(1500)
                                            ->icon('heroicon-o-envelope'),

                                        TextEntry::make('phone')
                                            ->label(__('messages.user.fields.phone'))
                                            ->copyable()
                                            ->copyMessage(__('messages.user.infolist.phone_copied'))
                                            ->copyMessageDuration(1500)
                                            ->icon('heroicon-o-phone'),

                                        TextEntry::make('type')
                                            ->label(__('messages.user.fields.type'))
                                            ->badge()
                                            ->color(fn (string $state): string => match ($state) {
                                                'admin' => 'success',
                                                'customer' => 'info',
                                                'company' => 'warning',
                                                default => 'gray',
                                            })
                                            ->formatStateUsing(fn (string $state): string => __('messages.user.types.' . $state))
                                            ->icon('heroicon-o-identification'),

                                        TextEntry::make('country.name')
                                            ->label(__('messages.user.fields.country'))
                                            ->placeholder(__('messages.user.infolist.no_country'))
                                            ->icon('heroicon-o-flag'),

                                        TextEntry::make('fcm_token')
                                            ->label(__('messages.user.fields.fcm_token'))
                                            ->placeholder(__('messages.user.infolist.no_fcm_token'))
                                            ->limit(20)
                                            ->tooltip(fn ($state) => $state)
                                            ->icon('heroicon-o-device-phone-mobile'),
                                    ])
                                    ->columnSpan(1),

                                // Right column - Status and timestamps
                                Grid::make(1)
                                    ->schema([
                                        IconEntry::make('is_active')
                                            ->label(__('messages.user.fields.is_active'))
                                            ->boolean()
                                            ->trueIcon('heroicon-o-check-circle')
                                            ->falseIcon('heroicon-o-x-circle')
                                            ->trueColor('success')
                                            ->falseColor('danger'),

                                        TextEntry::make('created_at')
                                            ->label(__('messages.user.infolist.created_at'))
                                            ->dateTime()
                                            ->since()
                                            ->icon('heroicon-o-calendar-days'),

                                        TextEntry::make('updated_at')
                                            ->label(__('messages.user.infolist.updated_at'))
                                            ->dateTime()
                                            ->since()
                                            ->icon('heroicon-o-pencil-square'),

                                        TextEntry::make('deleted_at')
                                            ->label(__('messages.user.infolist.deleted_at'))
                                            ->dateTime()
                                            ->since()
                                            ->placeholder(__('messages.user.infolist.not_deleted'))
                                            ->icon('heroicon-o-trash')
                                            ->color('danger')
                                            ->visible(fn ($record) => $record->deleted_at !== null),
                                    ])
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columnSpanFull(),

            ]);
    }
}