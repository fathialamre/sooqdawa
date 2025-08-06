<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use App\Filament\Actions\ChangePasswordAction;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('messages.user.table.columns.id'))
                    ->searchable()
                    ->sortable(),
                SpatieMediaLibraryImageColumn::make('avatar')
                    ->label(__('messages.user.table.columns.avatar'))
                    ->collection('avatar')
                    ->circular()
                    ->size(40),
                    
                TextColumn::make('name')
                    ->label(__('messages.user.table.columns.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label(__('messages.user.table.columns.email'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label(__('messages.user.table.columns.phone'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label(__('messages.user.table.columns.type'))
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => __('messages.user.types.admin'),
                        'customer' => __('messages.user.types.customer'),
                        'company' => __('messages.user.types.company'),
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'customer' => 'success',
                        'company' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('country.name')
                    ->label(__('messages.user.table.columns.country'))
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),

                ToggleColumn::make('is_active')
                    ->label(__('messages.user.table.columns.is_active')),

                TextColumn::make('created_at')
                    ->label(__('messages.user.table.columns.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('messages.user.table.columns.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->label(__('messages.user.table.columns.deleted_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label(__('messages.user.filters.type'))
                    ->options([
                        'admin' => __('messages.user.types.admin'),
                        'customer' => __('messages.user.types.customer'),
                        'company' => __('messages.user.types.company'),
                    ]),

                SelectFilter::make('country')
                    ->label(__('messages.user.filters.country'))
                    ->relationship('country', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('is_active')
                    ->label(__('messages.user.filters.is_active'))
                    ->options([
                        '1' => __('messages.common.active'),
                        '0' => __('messages.common.inactive'),
                    ]),

                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                ChangePasswordAction::make('md'),
                Action::make('block')
                    ->label(fn (User $record): string => $record->is_active ? __('messages.user.actions.block') : __('messages.user.actions.unblock'))
                    ->icon(fn (User $record): string => $record->is_active ? 'heroicon-o-no-symbol' : 'heroicon-o-check-circle')
                    ->color(fn (User $record): string => $record->is_active ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn (User $record): string => $record->is_active ? __('messages.user.actions.block_user') : __('messages.user.actions.unblock_user'))
                    ->modalDescription(fn (User $record): string => $record->is_active 
                        ? __('messages.user.modals.block.description', ['name' => $record->name])
                        : __('messages.user.modals.unblock.description', ['name' => $record->name])
                    )
                    ->modalSubmitActionLabel(fn (User $record): string => $record->is_active ? __('messages.user.actions.block') : __('messages.user.actions.unblock'))
                    ->action(function (User $record): void {
                        $record->is_active = !$record->is_active;
                        $record->save();
                        
                        $message = $record->is_active 
                            ? __('messages.user.notifications.user_unblocked', ['name' => $record->name])
                            : __('messages.user.notifications.user_blocked', ['name' => $record->name]);
                            
                        Notification::make()
                            ->title($message)
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordUrl(fn (User $record): string => UserResource::getUrl('view', ['record' => $record]));
    }
}
