<?php

namespace App\Filament\Actions;

use App\Models\User;
use App\Models\Wallet;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;

class TopupWalletAction
{
    public static function make(): Action
    {
        return Action::make('topup_wallet')
            ->label(__('messages.wallet.actions.topup'))
            ->icon('heroicon-o-plus-circle')
            ->color('success')
            ->modalHeading(__('messages.wallet.actions.topup_wallet'))
            ->modalDescription(__('messages.wallet.modals.topup.description'))
            ->modalSubmitActionLabel(__('messages.wallet.actions.topup'))
            ->schema([
                Select::make('user_id')
                    ->label(__('messages.wallet.fields.user'))
                    ->options(User::active()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->helperText(__('messages.wallet.form.helpers.user_selection')),

                TextInput::make('amount')
                    ->label(__('messages.wallet.fields.amount'))
                    ->numeric()
                    ->step(0.01)
                    ->minValue(0.01)
                    ->maxValue(10000)
                    ->prefix('LYD')
                    ->required()
                    ->helperText(__('messages.wallet.form.helpers.amount_range')),

                Textarea::make('description')
                    ->label(__('messages.wallet.fields.description'))
                    ->placeholder(__('messages.wallet.fields.topup_description_placeholder'))
                    ->rows(3)
                    ->maxLength(500)
                    ->columnSpanFull(),
            ])
            ->action(function (array $data): void {
                try {
                    // Create wallet credit transaction
                    $wallet = Wallet::createCredit(
                        userId: $data['user_id'],
                        amount: $data['amount'],
                        voucherId: null,
                        description: $data['description'] ?? __('messages.wallet.default_descriptions.topup', ['amount' => $data['amount']])
                    );

                    // Get user for notification
                    $user = User::find($data['user_id'], ['id', 'name']);

                    // Send success notification
                    Notification::make()
                        ->title(__('messages.wallet.notifications.topup_success'))
                        ->body(__('messages.wallet.notifications.topup_success_body', [
                            'user' => $user->name,
                            'amount' => number_format((float) $data['amount'], 2),
                            'balance' => number_format((float) $wallet->balance, 2),
                        ]))
                        ->success()
                        ->duration(5000)
                        ->send();

                } catch (\Exception $e) {
                    // Send error notification
                    Notification::make()
                        ->title(__('messages.wallet.notifications.topup_error'))
                        ->body(__('messages.wallet.notifications.topup_error_body', ['error' => $e->getMessage()]))
                        ->danger()
                        ->duration(8000)
                        ->send();

                    throw $e;
                }
            })
            ->requiresConfirmation()
            ->modalIcon('heroicon-o-currency-dollar')
            ->modalWidth('md');
    }
}