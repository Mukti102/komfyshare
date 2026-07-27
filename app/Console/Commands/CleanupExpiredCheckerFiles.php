<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupExpiredCheckerFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checker:cleanup-files';
    protected $description = 'Menghapus file fisik dari pesanan Checker yang usianya melebihi batas kedaluwarsa 7 hari.';

    public function handle()
    {
        $this->info('Memulai pengecekan file kedaluwarsa...');

        // Ambil order yang sudah completed dan lewat 7 hari
        $expiredDateLimit = now()->subDays(7);

        $orders = \App\Models\CheckerOrder::where('status', 'completed')
            ->whereNotNull('completed_at')
            ->where('completed_at', '<=', $expiredDateLimit)
            ->with('files')
            ->get();

        $deletedCount = 0;

        foreach ($orders as $order) {
            foreach ($order->files as $file) {
                // Hapus file fisik dari storage
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($file->file_path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($file->file_path);
                    $deletedCount++;
                }
                
                // Hapus record file (soft/hard delete tergantung setting, disini hard delete aman karena fisiknya sudah tak ada)
                $file->delete();
            }
        }

        $this->info("Pembersihan selesai! Total $deletedCount file telah dihapus secara permanen.");
    }
}
