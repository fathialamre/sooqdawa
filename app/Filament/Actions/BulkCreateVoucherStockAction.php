<?php

namespace App\Filament\Actions;

use App\Models\Voucher;
use App\Models\VoucherStock;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class BulkCreateVoucherStockAction
{
    public static function make(?int $voucherId = null, string $modalWidth = 'sm'): Action
    {
        return Action::make('bulk_create_voucher_stock')
            ->label(__('messages.voucher_stock.actions.bulk_create'))
            ->icon('heroicon-o-squares-plus')
            ->color('info')
            ->modalHeading(__('messages.voucher_stock.actions.bulk_create'))
            ->modalSubmitActionLabel(__('messages.voucher_stock.actions.bulk_create'))
            ->schema([
                // Only show voucher selection if no voucher ID is provided
                Select::make('voucher_id')
                    ->label(__('messages.voucher_stock.fields.voucher'))
                    ->options(Voucher::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->placeholder(__('messages.voucher_stock.placeholders.select_voucher'))
                    ->disabled(fn() => $voucherId === null)
                    ->default($voucherId),

                TextInput::make('quantity')
                    ->label(__('messages.voucher_stock.fields.quantity'))
                    ->helperText(__('messages.voucher_stock.helpers.quantity'))
                    ->required()
                    ->integer()
                    ->minValue(1)
                    ->maxValue(200)
                    ->default(10),
            ])
            ->modalWidth($modalWidth)
            ->action(function (array $data): void {
                try {
                    $quantity = (int) $data['quantity'];
                    $voucherId = (int) $data['voucher_id'];

                    // Get voucher name for notification
                    $voucher = Voucher::find($voucherId, ['id', 'name']);

                    VoucherStock::createBulkStock($voucherId, $quantity);

                    // Send success notification
                    Notification::make()
                        ->title(__('messages.voucher_stock.notifications.bulk_created'))
                        ->body(__('messages.voucher_stock.notifications.bulk_created_body', [
                            'quantity' => $quantity,
                            'voucher' => $voucher->name ?? 'Unknown',
                        ]))
                        ->success()
                        ->duration(5000)
                        ->send();

                } catch (\Exception $e) {
                    // Send error notification
                    Notification::make()
                        ->title(__('messages.voucher_stock.notifications.bulk_create_error'))
                        ->body(__('messages.voucher_stock.notifications.bulk_create_error_body', ['error' => $e->getMessage()]))
                        ->danger()
                        ->duration(8000)
                        ->send();

                    throw $e;
                }
            })
            ->requiresConfirmation()
            ->modalIcon('heroicon-o-squares-plus');
    }
} 