<?php

namespace Database\Seeders;

use App\Models\Costumer;
use App\Models\CheckerPackage;
use App\Models\CheckerTokenWallet;
use App\Models\CheckerTokenHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestTokenCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Customer Test
        $customer = Costumer::firstOrCreate(
            ['phone' => '081234567890'], // Nomor WA Test
            ['name' => 'Testing Token User']
        );

        // 2. Ambil Paket pertama yang ada (Pastikan sudah ada data CheckerPackage di DB)
        $package = CheckerPackage::first();

        if (!$package) {
            $this->command->error('Tidak ada CheckerPackage di database. Harap buat paket terlebih dahulu.');
            return;
        }

        // 3. Buatkan dompet token aktif
        $wallet = CheckerTokenWallet::firstOrCreate(
            [
                'customer_id' => $customer->id,
                'checker_package_id' => $package->id,
            ],
            [
                'total_token' => 10, // Beri 10 token
                'expired_at' => now()->addDays(30)
            ]
        );

        // Tambah histori token masuk
        CheckerTokenHistory::create([
            'checker_token_wallet_id' => $wallet->id,
            'checker_package_id' => $package->id,
            'type' => 'bonus',
            'token' => 10,
            'balance_before' => 0,
            'balance_after' => 10,
            'description' => 'Top-Up Gratis via Seeder',
        ]);

        $this->command->info('Berhasil! Nomor WA untuk testing: 081234567890 (Saldo: 10 Token, Paket: ' . $package->name . ')');
    }
}
