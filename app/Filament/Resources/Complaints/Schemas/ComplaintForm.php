<?php

namespace App\Filament\Resources\Complaints\Schemas;

use App\Models\Complaint;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ComplaintForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('messages.complaint.sections.basic_info'))
                    ->schema([
                        Select::make('user_id')
                            ->label(__('messages.complaint.fields.user'))
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Textarea::make('body')
                            ->label(__('messages.complaint.fields.body'))
                            ->placeholder(__('messages.complaint.fields.body_placeholder'))
                            ->required()
                            ->rows(5)
                            ->maxLength(1000),

                        Select::make('status')
                            ->label(__('messages.complaint.fields.status'))
                            ->options([
                                'open' => __('messages.complaint.status.open'),
                                'resolved' => __('messages.complaint.status.resolved'),
                            ])
                            ->required()
                            ->default('open'),
                    ])
                    ->columns(1),
            ]);
    }
} 