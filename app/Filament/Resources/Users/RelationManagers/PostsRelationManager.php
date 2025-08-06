<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Enums\PostStatus;
use App\Filament\Resources\Departments\DepartmentResource;
use App\Filament\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public static function getTitle($owner, string $pageClass): string
    {
        return __('messages.post.navigation.plural');
    }

    public static function getModelLabel(): string
    {
        return __('messages.post.navigation.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.post.navigation.plural');
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('company')
            ->columns([
                TextColumn::make('id')
                    ->label(__('messages.post.table.columns.id'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('department.name')
                    ->label(__('messages.post.table.columns.department'))
                    ->url(fn (Post $record): string => DepartmentResource::getUrl('edit', ['record' => $record->department_id]))
                    ->numeric()
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->weight('bold')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->sortable(),
                TextColumn::make('company')
                    ->label(__('messages.post.table.columns.company'))
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('status')
                    ->label(__('messages.post.table.columns.status'))
                    ->formatStateUsing(fn (PostStatus $state): string => $state->getLabel())
                    ->badge()
                    ->color(fn (PostStatus $state): string => $state->getColor())
                    ->icon(fn (PostStatus $state): string => $state->getIcon())
                    ->searchable(),
                TextColumn::make('city.name')
                    ->label(__('messages.post.table.columns.city'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('country.name')
                    ->label(__('messages.post.table.columns.country'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('number_of_views')
                    ->label(__('messages.post.table.columns.number_of_views'))
                    ->icon('heroicon-o-eye')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                TextColumn::make('activity')
                    ->label(__('messages.post.table.columns.activity'))
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__('messages.post.table.columns.phone'))
                    ->searchable(),
                TextColumn::make('price')
                    ->label(__('messages.post.table.columns.price'))
                    ->money()
                    ->sortable(),
                TextColumn::make('currency')
                    ->label(__('messages.post.table.columns.currency'))
                    ->searchable(),
                TextColumn::make('deleted_at')
                    ->label(__('messages.post.table.columns.deleted_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label(__('messages.post.table.columns.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('messages.post.table.columns.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->url(fn (): string => PostResource::getUrl('create', [
                        'user_id' => $this->getOwnerRecord()->getKey()
                    ])),
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn (Post $record): string => PostResource::getUrl('view', ['record' => $record])),
                EditAction::make()
                    ->url(fn (Post $record): string => PostResource::getUrl('edit', ['record' => $record])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}