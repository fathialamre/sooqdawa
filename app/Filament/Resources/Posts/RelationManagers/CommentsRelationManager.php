<?php

namespace App\Filament\Resources\Posts\RelationManagers;

use App\Models\User;
use App\Models\Comment;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Users\UserResource;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Support\Facades\Auth;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $title = null;

    public static function getTitle($owner, string $pageClass): string
    {
        return __('messages.comment.relations.title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(fn () => Auth::id()),

                Textarea::make('comment')
                    ->label(__('messages.comment.form.comment'))
                    ->required()
                    ->rows(4)
                    ->maxLength(65535),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([
                TextColumn::make('id')
                    ->label(__('messages.comment.table.columns.id'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->url(fn (Comment $record): string => UserResource::getUrl('view', ['record' => $record->user_id]))
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->weight('bold')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->label(__('messages.comment.table.columns.user'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('comment')
                    ->label(__('messages.comment.table.columns.comment'))
                    ->limit(100)
                    ->searchable()
                    ->wrap(),

                IconColumn::make('deleted_at')
                    ->label(__('messages.comment.table.columns.deleted'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('danger')
                    ->falseColor('success')
                    ->getStateUsing(fn ($record) => !is_null($record->deleted_at))
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('messages.comment.table.columns.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label(__('messages.comment.table.columns.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('messages.comment.actions.create'))
                    ->modalHeading(__('messages.comment.modal.create.heading'))
                    ->modalSubmitActionLabel(__('messages.comment.modal.create.submit'))
                    ->modalCancelActionLabel(__('messages.comment.modal.create.cancel'))
                    ->modalWidth('md'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label(__('messages.comment.actions.edit'))
                    ->modalHeading(__('messages.comment.modal.edit.heading'))
                    ->modalSubmitActionLabel(__('messages.comment.modal.edit.submit'))
                    ->modalCancelActionLabel(__('messages.comment.modal.edit.cancel'))
                    ->modalWidth('md'),
                DeleteAction::make()
                    ->label(__('messages.comment.actions.delete'))
                    ->modalHeading(__('messages.comment.modal.delete.heading'))
                    ->modalDescription(__('messages.comment.modal.delete.description'))
                    ->modalSubmitActionLabel(__('messages.comment.modal.delete.submit'))
                    ->modalCancelActionLabel(__('messages.comment.modal.delete.cancel')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}