<?php

namespace App\Filament\Resources\Posts\RelationManagers;

use App\Models\Like;
use App\Models\User;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\Users\UserResource;
use Filament\Resources\RelationManagers\RelationManager;

class LikesRelationManager extends RelationManager
{
    protected static string $relationship = 'likes';

    protected static ?string $title = null;

    public static function getTitle($owner, string $pageClass): string
    {
        return __('messages.like.relations.title');
    }


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->columns([
                TextColumn::make('id')
                    ->label(__('messages.like.table.columns.id'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label(__('messages.like.table.columns.user'))
                   ->url(fn (Like $record): string => UserResource::getUrl('view', ['record' => $record->user_id]))
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->weight('bold')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.email')
                    ->label(__('messages.like.table.columns.email'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('messages.like.table.columns.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
          
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}