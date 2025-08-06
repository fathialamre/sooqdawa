<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DepartmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('messages.department.infolist.section.basic'))
                    ->description(__('messages.department.infolist.section.basic_description'))
                    ->schema([
                        Grid::make(columns: 3)
                            ->schema([
                                // Left column - Department image
                                Grid::make(1)
                                    ->schema([
                                        SpatieMediaLibraryImageEntry::make('photo')
                                            ->label(__('messages.department.infolist.fields.photo'))
                                            ->collection('default')
                                            ->circular()
                                            ->size(150)
                                            ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name ?? 'Department') . '&color=7F9CF5&background=EBF4FF')
                                            ->hiddenLabel(),

                                        TextEntry::make('name')
                                            ->label(__('messages.department.infolist.fields.name'))
                                            ->size('lg')
                                            ->weight('bold')
                                            ->color('primary')
                                            ->icon('heroicon-o-rectangle-stack'),
                                    ])
                                    ->columnSpan(1),

                                // Middle column - Status and details
                                Grid::make(1)
                                    ->schema([
                                        IconEntry::make('is_active')
                                            ->label(__('messages.department.infolist.fields.is_active'))
                                            ->boolean()
                                            ->trueIcon('heroicon-o-check-circle')
                                            ->falseIcon('heroicon-o-x-circle')
                                            ->trueColor('success')
                                            ->falseColor('danger'),
                                    ])
                                    ->columnSpan(1),

                                // Right column - Timestamps
                                Grid::make(1)
                                    ->schema([
                                        TextEntry::make('created_at')
                                            ->label(__('messages.department.infolist.fields.created_at'))
                                            ->dateTime()
                                            ->since()
                                            ->icon('heroicon-o-calendar-days'),

                                        TextEntry::make('updated_at')
                                            ->label(__('messages.department.infolist.fields.updated_at'))
                                            ->dateTime()
                                            ->since()
                                            ->icon('heroicon-o-pencil-square'),

                                        TextEntry::make('id')
                                            ->label(__('messages.department.infolist.fields.id'))
                                            ->copyable()
                                            ->copyMessage(__('messages.department.infolist.copy_message'))
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