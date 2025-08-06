<?php

namespace App\Filament\Actions;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordAction
{
    public static function make(string $modalWidth = 'md'): Action
    {
        return Action::make('change_password')
            ->label(__('messages.user.actions.change_password'))
            ->icon('heroicon-o-key')
            ->color('warning')
            ->schema([
                TextInput::make('new_password')
                    ->label(__('messages.user.modals.change_password.new_password'))
                    ->password()
                    ->revealable()
                    ->required()
                    ->rule(Password::default()),

                TextInput::make('new_password_confirmation')
                    ->label(__('messages.user.modals.change_password.confirm_password'))
                    ->password()
                    ->revealable()
                    ->required()
                    ->same('new_password'),
            ])
            ->modalHeading(__('messages.user.modals.change_password.title'))
            ->modalDescription(__('messages.user.modals.change_password.description'))
            ->modalSubmitActionLabel(__('messages.user.modals.change_password.submit'))
            ->modalWidth($modalWidth)
            ->action(function (User $record, array $data) {
                $record->update(['password' => Hash::make($data['new_password'])]);
                
                Notification::make()
                    ->title(__('messages.user.notifications.password_changed'))
                    ->success()
                    ->send();
            });
    }
}