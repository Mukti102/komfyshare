<?php

namespace App\Filament\Resources\CheckerOrderResource\Pages;

use App\Filament\Resources\CheckerOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCheckerOrder extends ViewRecord
{
    protected static string $resource = CheckerOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('upload_result')
                ->label('Upload Hasil')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('result_file')
                        ->label('File Hasil Proses')
                        ->disk('public')
                        ->directory('checker_files')
                        ->preserveFilenames()
                        ->required(),
                    \Filament\Forms\Components\Textarea::make('notes')
                        ->label('Catatan Tambahan (Opsional)'),
                    \Filament\Forms\Components\Select::make('status')
                        ->label('Update Status Order')
                        ->options([
                            'completed' => 'Selesai (Completed)',
                            'review' => 'Perlu Direview (Review)',
                        ])
                        ->default('completed')
                        ->required(),
                ])
                ->action(function (\App\Models\CheckerOrder $record, array $data): void {
                    $wasCompleted = $record->status === 'completed';
                    
                    if (isset($data['result_file'])) {
                        $fullPath = storage_path('app/public/' . $data['result_file']);
                        
                        $record->files()->create([
                            'category' => 'result',
                            'original_name' => basename($data['result_file']),
                            'file_name' => basename($data['result_file']),
                            'extension' => pathinfo($data['result_file'], PATHINFO_EXTENSION),
                            'mime_type' => file_exists($fullPath) ? mime_content_type($fullPath) : 'application/octet-stream',
                            'file_size' => file_exists($fullPath) ? filesize($fullPath) : 0,
                            'file_path' => $data['result_file'],
                            'uploaded_by' => 'admin',
                        ]);
                    }
                    
                    $record->update([
                        'status' => $data['status'],
                    ]);
                    
                    if (!empty($data['notes'])) {
                         $record->statusLogs()->create([
                             'status' => $data['status'],
                             'notes' => $data['notes'],
                             'created_by' => 'admin'
                         ]);
                    }
                    
                    if (!$wasCompleted && $data['status'] === 'completed' && $record->customer && $record->customer->phone) {
                        $message = "Halo {$record->customer->name},\n\nPesanan pengecekan dokumen Anda (Invoice: *{$record->invoice_number}*) telah *SELESAI* diproses.\n\nSilakan cek dan unduh hasilnya di link berikut:\n" . route('checker.track.detail', $record->invoice_number) . "\n\nTerima kasih telah menggunakan layanan KomfyChecker!";
                        \App\Jobs\SendWhatsapp::dispatch($record->customer->phone, $message);
                    }
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Hasil berhasil diupload')
                        ->success()
                        ->send();
                })
                ->visible(fn (\App\Models\CheckerOrder $record) => !in_array($record->status, ['completed', 'cancelled'])),
        ];
    }
}
