<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\DeleteAction;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\DissociateBulkAction;
use App\Filament\Resources\Users\UserResource;
use Filament\Resources\RelationManagers\RelationManager;

class FollowersRelationManager extends RelationManager
{
    protected static string $relationship = 'followers';

    protected static ?string $title = null;

    public static function getTitle($owner, string $pageClass): string
    {
        return __('messages.user.relations.followers.title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id')
                    ->label(__('messages.user.relations.followers.user'))
                    ->options(
                        User::where('id', '!=', $this->ownerRecord->id)
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('avatar_url')
                    ->label(__('messages.user.table.columns.avatar'))
                    ->circular()
                    ->defaultImageUrl(fn() => 'https://ui-avatars.com/api/?name=' . urlencode('User') . '&color=7F9CF5&background=EBF4FF')
                 ,
                TextColumn::make('name')
                    ->url(fn($record) => UserResource::getUrl('view', ['record' => $record->id]))
                    ->openUrlInNewTab()
                    ->color('info')
                    ->icon('heroicon-o-link')
                    ->limit(50)
                    ->searchable()
                    ->label(__('messages.user.relations.followers.user'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('messages.user.fields.email'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pivot_created_at')
                    ->label(__('messages.user.relations.followers.followed_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AssociateAction::make()
                    ->preloadRecordSelect()
                    ->recordSelectOptionsQuery(
                        fn($query) => $query->where('id', '!=', $this->ownerRecord->id)
                    ),
            ])
            ->recordActions([
                DissociateAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                ]),
            ])
            ->defaultSort('pivot_created_at', 'desc');
    }
}
