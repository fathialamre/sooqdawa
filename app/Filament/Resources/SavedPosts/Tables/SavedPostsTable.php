<?php

namespace App\Filament\Resources\SavedPosts\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;
use App\Filament\Resources\Posts\PostResource;
use App\Filament\Resources\Users\UserResource;

class SavedPostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('messages.common.id'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('user.name')
                    ->url(fn($record) => UserResource::getUrl('view', ['record' => $record->user_id]))
                    ->openUrlInNewTab()
                    ->weight('bold')
                    ->color('info')
                    ->icon('heroicon-o-link')
                    ->label(__('messages.saved_post.table.columns.user'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('post.description')
                    ->label(__('messages.saved_post.table.columns.post'))
                    ->url(fn($record) => PostResource::getUrl('view', ['record' => $record->post_id]))
                    ->openUrlInNewTab()
                    ->color('info')
                    ->weight('bold')
                    ->icon('heroicon-o-link')
                    ->limit(50)
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label(__('messages.saved_post.table.columns.saved_at'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label(__('messages.saved_post.table.columns.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
               
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
