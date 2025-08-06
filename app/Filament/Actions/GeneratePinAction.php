<?php

namespace App\Filament\Actions;

use App\Models\VoucherStock;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Notifications\Notification;

class GeneratePinAction
{
    public static function make(string $fieldName = 'pin'): Action
    {
        return Action::make('generate_pin')
            ->label(__('messages.voucher_stock.actions.generate'))
            ->icon('heroicon-o-arrow-path')
            ->color('warning')
            ->modalHeading(__('messages.voucher_stock.actions.generate_pin'))
            ->modalDescription(__('messages.voucher_stock.helpers.pin'))
            ->schema([
                TextInput::make('generated_pin')
                    ->label(__('messages.voucher_stock.fields.pin'))
                    ->default(fn() => VoucherStock::generateUniquePin())
                    ->readonly()
                    ->copyable()
                    ->copyMessage(__('messages.voucher_stock.actions.pin_copied')),
            ])
            ->modalWidth('sm')
            ->action(function (array $data, $livewire) use ($fieldName): void {
                $newPin = VoucherStock::generateUniquePin();
                
                // Update the form field if we're in a form context
                if (method_exists($livewire, 'form')) {
                    $livewire->form->fill([$fieldName => $newPin]);
                }
                
                // Send success notification
                Notification::make()
                    ->title(__('messages.voucher_stock.notifications.pin_generated'))
                    ->body(__('messages.voucher_stock.notifications.pin_generated_body', ['pin' => $newPin]))
                    ->success()
                    ->duration(3000)
                    ->send();
            })
            ->modalIcon('heroicon-o-key');
    }
} 