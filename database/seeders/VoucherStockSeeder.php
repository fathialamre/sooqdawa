<?php

namespace Database\Seeders;

use App\Models\Voucher;
use App\Models\VoucherStock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all vouchers
        $vouchers = Voucher::all();

        if ($vouchers->isEmpty()) {
            $this->command->error('Please run VoucherSeeder first.');
            return;
        }

        $totalStockCreated = 0;

        foreach ($vouchers as $voucher) {
            // Create 10 stock items for each voucher
            for ($i = 1; $i <= 10; $i++) {
                VoucherStock::create([
                    'voucher_id' => $voucher->id,
                    'pin' => VoucherStock::generateUniquePin(),
                    'used' => false,
                    'used_at' => null,
                ]);
                $totalStockCreated++;
            }
        }

        $this->command->info("Voucher stock seeder completed successfully! Created {$totalStockCreated} voucher stock items (10 for each voucher).");
    }
}