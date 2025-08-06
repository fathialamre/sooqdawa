<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define voucher data
        $vouchers = [
            [
                'name' => 'Voucher 10',
                'price' => 10.00,
                'is_active' => true,
            ],
            [
                'name' => 'Voucher 50',
                'price' => 50.00,
                'is_active' => true,
            ],
            [
                'name' => 'Voucher 100',
                'price' => 100.00,
                'is_active' => true,
            ],
        ];

        foreach ($vouchers as $voucherData) {
            Voucher::create($voucherData);
        }

        $this->command->info('Voucher seeder completed successfully! Created ' . count($vouchers) . ' vouchers.');
    }
}