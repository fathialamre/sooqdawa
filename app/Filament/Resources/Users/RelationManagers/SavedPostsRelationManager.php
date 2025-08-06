<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\CreateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\Posts\PostResource;
use Filament\Resources\RelationManagers\RelationManager;

class SavedPostsRelationManager extends RelationManager
{
    protected static string $relationship = 'savedPosts';

    public static function getTitle($owner, string $pageClass): string
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('post.description')
                    ->url(fn($record) => PostResource::getUrl('view', ['record' => $record->post_id]))
                    ->openUrlInNewTab()
                    ->color('info')
                    ->icon('heroicon-o-link')
                    ->label(__('messages.saved_post.table.columns.post'))
                    ->limit(50)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('post.department.name')
                    ->label(__('messages.saved_post.table.columns.department'))
                    ->sortable(),

                TextColumn::make('post.price')
                    ->label(__('messages.saved_post.table.columns.price'))
                    ->money('LYD')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('messages.saved_post.table.columns.saved_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                
            ]) ;
    }
} 