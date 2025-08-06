<?php

namespace App\Filament\Resources\UserPlans;

use App\Filament\Resources\UserPlans\Pages\CreateUserPlan;
use App\Filament\Resources\UserPlans\Pages\ListUserPlans;
use App\Filament\Resources\UserPlans\Pages\ViewUserPlan;
use App\Filament\Resources\UserPlans\Schemas\UserPlanForm;
use App\Filament\Resources\UserPlans\Schemas\UserPlanInfolist;
use App\Filament\Resources\UserPlans\Tables\UserPlansTable;
use App\Models\UserPlan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserPlanResource extends Resource
{
    protected static ?string $model = UserPlan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CreditCard;

    protected static ?string $recordTitleAttribute = 'id';

    public static function getLabel(): string
    {
        return __('messages.user_plan.navigation.label');
    }

    public static function getPluralLabel(): string
    {
        return __('messages.user_plan.navigation.plural_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('messages.navigation.groups.content');
    }

    public static function form(Schema $schema): Schema
    {
        return UserPlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserPlansTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserPlanInfolist::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserPlans::route('/'),
            'create' => CreateUserPlan::route('/create'),
            'view' => ViewUserPlan::route('/{record}'),
        ];
    }
}
