<?php

namespace App\Filament\Actions;

use App\Models\Voucher;
use App\Models\VoucherStock;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class CreateVoucherStockAction
{
    public static function make(?int $voucherId = null, string $modalWidth = 'sm'): Action
    {
        return Action::make('create_voucher_stock')
            ->label(__('messages.voucher_stock.actions.create'))
            ->icon('heroicon-o-plus-circle')
            ->color('success')
            ->modalHeading(__('messages.voucher_stock.actions.create'))
            ->modalSubmitActionLabel(__('messages.voucher_stock.actions.create'))
            ->schema([
                // Only show voucher selection if no voucher ID is provided
                Select::make('voucher_id')
                    ->label(__('messages.voucher_stock.fields.voucher'))
                    ->options(Voucher::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->placeholder(__('messages.voucher_stock.placeholders.select_voucher'))
                    ->visible(fn() => $voucherId === null)
                    ->default($voucherId),

                // Hidden field for voucher ID when provided
                Hidden::make('voucher_id')
                    ->default($voucherId)
                    ->visible(fn() => $voucherId !== null),

                TextInput::make('pin')
                    ->label(__('messages.voucher_stock.fields.pin'))
                    ->helperText(__('messages.voucher_stock.helpers.pin'))
                    ->default(fn() => VoucherStock::generateUniquePin())
                    ->required()
                    ->unique(VoucherStock::class, 'pin')
                    ->maxLength(12)
                    ->minLength(12)
                    ->suffixAction(
                        Action::make('generate_pin')
                            ->label(__('messages.voucher_stock.actions.generate'))
                            ->icon('heroicon-o-arrow-path')
                            ->action(function (Set $set) {
                                $set('pin', VoucherStock::generateUniquePin());
                            })
                    ),

                Toggle::make('used')
                    ->label(__('messages.voucher_stock.fields.used'))
                    ->default(false)
                    ->reactive()
                    ->afterStateUpdated(function (Set $set, $state) {
                        if (!$state) {
                            $set('used_at', null);
                        }
                    }),

                DateTimePicker::make('used_at')
                    ->label(__('messages.voucher_stock.fields.used_at'))
                    ->visible(fn(Get $get) => $get('used'))
                    ->default(now())
                    ->required(fn(Get $get) => $get('used')),
            ])
            ->modalWidth($modalWidth)
            ->action(function (array $data): void {
                try {
                    // Ensure voucher_id is set
                    if (!isset($data['voucher_id']) || empty($data['voucher_id'])) {
                        throw new \Exception(__('messages.voucher_stock.errors.voucher_required'));
                    }

                    // Create the voucher stock
                    $voucherStock = VoucherStock::create($data);

                    // Get voucher name for notification
                    $voucher = Voucher::find($data['voucher_id'], ['id', 'name']);

                    // Send success notification
                    Notification::make()
                        ->title(__('messages.voucher_stock.notifications.created'))
                        ->body(__('messages.voucher_stock.notifications.created_body', [
                            'pin' => $voucherStock->pin,
                            'voucher' => $voucher->name ?? 'Unknown',
                        ]))
                        ->success()
                        ->duration(5000)
                        ->send();

                } catch (\Exception $e) {
                    // Send error notification
                    Notification::make()
                        ->title(__('messages.voucher_stock.notifications.create_error'))
                        ->body(__('messages.voucher_stock.notifications.create_error_body', ['error' => $e->getMessage()]))
                        ->danger()
                        ->duration(8000)
                        ->send();

                    throw $e;
                }
            })
            ->requiresConfirmation()
            ->modalIcon('heroicon-o-credit-card');
    }
} 