<?php

namespace App\Filament\Resources\Complaints\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class ComplaintInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('messages.complaint.sections.basic_info'))
                    ->schema([
                        TextEntry::make('id')
                            ->label('ID'),

                        TextEntry::make('body')
                            ->label(__('messages.complaint.fields.body'))
                            ->markdown(),

                        TextEntry::make('status')
                            ->label(__('messages.complaint.fields.status'))
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'open' => 'warning',
                                'resolved' => 'success',
                                default => 'gray',
                            }),
                    ])
                    ->columns(1),

                Section::make(__('messages.complaint.sections.customer_info'))
                    ->schema([
                        TextEntry::make('user.name')
                            ->label(__('messages.complaint.fields.user')),

                        TextEntry::make('user.email')
                            ->label('Email'),

                        TextEntry::make('user.phone')
                            ->label('Phone'),
                    ])
                    ->columns(3),

                Section::make(__('messages.complaint.sections.timestamps'))
                    ->schema([
                        TextEntry::make('created_at')
                            ->label(__('messages.complaint.fields.created_at'))
                            ->dateTime(),

                        TextEntry::make('updated_at')
                            ->label(__('messages.complaint.fields.updated_at'))
                            ->dateTime(),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
} 