<?php

namespace App\Filament\Resources\SavedPosts;

use App\Filament\Resources\SavedPosts\Pages\CreateSavedPost;
use App\Filament\Resources\SavedPosts\Pages\EditSavedPost;
use App\Filament\Resources\SavedPosts\Pages\ListSavedPosts;
use App\Filament\Resources\SavedPosts\Schemas\SavedPostForm;
use App\Filament\Resources\SavedPosts\Tables\SavedPostsTable;
use App\Models\SavedPost;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SavedPostResource extends Resource
{
    protected static ?string $model = SavedPost::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Bookmark;

    public static function getNavigationGroup(): ?string
    {
        return __('messages.navigation.groups.content');
    }

    public static function getNavigationLabel(): string
    {
        return __('messages.saved_post.navigation.plural_label');
    }

    public static function getModelLabel(): string
    {
        return __('messages.saved_post.navigation.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.saved_post.navigation.plural_label');
    }

    public static function form(Schema $schema): Schema
    {
        return SavedPostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SavedPostsTable::configure($table);
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
            'index' => ListSavedPosts::route('/'),
         
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
