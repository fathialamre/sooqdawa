<?php

namespace App\Filament\Resources\UserPlans\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('messages.user_plan.form.sections.basic'))
                    ->schema([
                        Select::make('user_id')
                            ->label(__('messages.user_plan.form.fields.user'))
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('plan_id')
                            ->label(__('messages.user_plan.form.fields.plan'))
                            ->relationship('plan', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->helperText(__('messages.user_plan.form.helpers.plan_selection')),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
