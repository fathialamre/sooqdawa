<?php

namespace App\Filament\Resources\OffensiveWords;

use App\Filament\Resources\OffensiveWords\Pages\ListOffensiveWords;
use App\Filament\Resources\OffensiveWords\Schemas\OffensiveWordForm;
use App\Filament\Resources\OffensiveWords\Schemas\OffensiveWordInfolist;
use App\Filament\Resources\OffensiveWords\Tables\OffensiveWordsTable;
use App\Models\OffensiveWord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OffensiveWordResource extends Resource
{
    protected static ?string $model = OffensiveWord::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ShieldExclamation;

    protected static ?string $recordTitleAttribute = 'word';

    public static function getLabel(): string
    {
        return __('messages.offensive_word.navigation.label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('messages.offensive_word.navigation.group');
    }

    public static function getPluralLabel(): string
    {
        return __('messages.offensive_word.navigation.plural_label');
    }

    public static function form(Schema $schema): Schema
    {
        return OffensiveWordForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OffensiveWordsTable::configure($table);
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
            'index' => ListOffensiveWords::route('/'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
} 