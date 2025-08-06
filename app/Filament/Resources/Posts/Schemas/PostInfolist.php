<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\PostStatus;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Main Information Section
                Section::make(__('messages.post.infolist.section.basic'))
                    ->description(__('messages.post.infolist.section.basic_description'))
                    ->schema([
                        Grid::make(columns: 3)
                            ->schema([
                                // Left column - Post images
                                Grid::make(1)
                                    ->schema([
                                        SpatieMediaLibraryImageEntry::make('images')
                                            ->label(__('messages.post.infolist.fields.images'))
                                            ->collection('images')
                                            ->conversion('preview')
                                            ->size(200)
                                            ->circular(false)
                                            ->hiddenLabel(),

                                        TextEntry::make('description')
                                            ->label(__('messages.post.infolist.fields.description'))
                                            ->markdown()
                                            ->prose()
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpan(2),

                                // Right column - Status and key info
                                Grid::make(1)
                                    ->schema([
                                        TextEntry::make('id')
                                            ->label(__('messages.post.infolist.fields.id'))
                                            ->copyable()
                                            ->copyMessage(__('messages.post.infolist.copy_message'))
                                            ->copyMessageDuration(1500)
                                            ->icon('heroicon-o-hashtag')
                                            ->badge()
                                            ->color('gray'),

                                        TextEntry::make('status')
                                            ->label(__('messages.post.infolist.fields.status'))
                                            ->badge()
                                            ->color(fn (PostStatus $state): string => $state->getColor())
                                            ->formatStateUsing(fn (PostStatus $state): string => $state->getLabel())
                                            ->icon(fn (PostStatus $state): string => $state->getIcon()),

                                        TextEntry::make('number_of_views')
                                            ->label(__('messages.post.infolist.fields.number_of_views'))
                                            ->numeric()
                                            ->icon('heroicon-o-eye')
                                            ->badge()
                                            ->color('info'),

                                        TextEntry::make('formatted_price')
                                            ->label(__('messages.post.infolist.fields.price'))
                                            ->badge()
                                            ->color('success')
                                            ->icon('heroicon-o-currency-dollar')
                                            ->visible(fn ($record) => $record->price && $record->currency),
                                    ])
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columnSpanFull(),

                // Additional Information
                Section::make(__('messages.post.infolist.section.details'))
                    ->description(__('messages.post.infolist.section.details_description'))
                    ->schema([
                        // Company & Department Information
                        Grid::make(columns: 2)
                            ->schema([
                                TextEntry::make('department.name')
                                    ->label(__('messages.post.infolist.fields.department'))
                                    ->icon('heroicon-o-building-office')
                                    ->badge()
                                    ->color('primary'),

                                TextEntry::make('company')
                                    ->label(__('messages.post.infolist.fields.company'))
                                    ->icon('heroicon-o-building-office-2')
                                    ->placeholder(__('messages.post.infolist.placeholders.company'))
                                    ->visible(fn ($record) => !empty($record->company)),

                                TextEntry::make('activity')
                                    ->label(__('messages.post.infolist.fields.activity'))
                                    ->icon('heroicon-o-briefcase')
                                    ->placeholder(__('messages.post.infolist.placeholders.activity'))
                                    ->visible(fn ($record) => !empty($record->activity)),

                                TextEntry::make('user.name')
                                    ->label(__('messages.post.infolist.fields.user'))
                                    ->icon('heroicon-o-user')
                                    ->badge()
                                    ->color('info'),
                            ]),

                        // Location Information
                        Grid::make(columns: 2)
                            ->schema([
                                TextEntry::make('country.name')
                                    ->label(__('messages.post.infolist.fields.country'))
                                    ->icon('heroicon-o-globe-americas')
                                    ->badge()
                                    ->color('success'),

                                TextEntry::make('city.name')
                                    ->label(__('messages.post.infolist.fields.city'))
                                    ->icon('heroicon-o-map-pin')
                                    ->badge()
                                    ->color('info')
                                    ->placeholder(__('messages.post.infolist.placeholders.city'))
                                    ->visible(fn ($record) => !empty($record->city_id)),

                                TextEntry::make('address')
                                    ->label(__('messages.post.infolist.fields.address'))
                                    ->icon('heroicon-o-map')
                                    ->placeholder(__('messages.post.infolist.placeholders.address'))
                                    ->visible(fn ($record) => !empty($record->address))
                                    ->columnSpanFull(),

                                TextEntry::make('phone')
                                    ->label(__('messages.post.infolist.fields.phone'))
                                    ->icon('heroicon-o-phone')
                                    ->copyable()
                                    ->copyMessage(__('messages.post.infolist.copy_phone'))
                                    ->placeholder(__('messages.post.infolist.placeholders.phone'))
                                    ->visible(fn ($record) => !empty($record->phone)),
                            ]),

                        // Tags
                        TextEntry::make('tags')
                            ->label(__('messages.post.infolist.fields.tags'))
                            ->badge()
                            ->separator(',')
                            ->color('gray')
                            ->placeholder(__('messages.post.infolist.placeholders.tags'))
                            ->visible(fn ($record) => !empty($record->tags))
                            ->columnSpanFull(),

                        // Timestamps
                        Grid::make(columns: 3)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label(__('messages.post.infolist.fields.created_at'))
                                    ->dateTime()
                                    ->since()
                                    ->icon('heroicon-o-calendar-days')
                                    ->color('success'),

                                TextEntry::make('updated_at')
                                    ->label(__('messages.post.infolist.fields.updated_at'))
                                    ->dateTime()
                                    ->since()
                                    ->icon('heroicon-o-pencil-square')
                                    ->color('warning'),

                                TextEntry::make('deleted_at')
                                    ->label(__('messages.post.infolist.fields.deleted_at'))
                                    ->dateTime()
                                    ->since()
                                    ->icon('heroicon-o-trash')
                                    ->color('danger')
                                    ->placeholder(__('messages.post.infolist.placeholders.not_deleted'))
                                    ->visible(fn ($record) => !empty($record->deleted_at)),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->columns(1),
            ]);
    }
}
