<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckerOrderResource\Pages;
use App\Filament\Resources\CheckerOrderResource\RelationManagers;
use App\Models\CheckerOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CheckerOrderResource extends Resource
{
    protected static ?string $model = CheckerOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Komfy Checker / Transactions';

    protected static ? string $navigationLabel = "Transaksi";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Details')
                    ->schema([
                        Forms\Components\TextInput::make('invoice_number')
                            ->label('Nomor Invoice')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('customer_id')
                            ->label('Customer')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('checker_service_id')
                            ->label('Layanan Checker')
                            ->relationship('service', 'name')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('checker_package_id')
                            ->label('Paket Token')
                            ->relationship('package', 'name')
                            ->searchable(),
                        Forms\Components\Select::make('payment_method_id')
                            ->label('Metode Pembayaran')
                            ->relationship('paymentMethod', 'name')
                            ->searchable(),
                        Forms\Components\Select::make('payment_type')
                            ->label('Tipe Pembayaran')
                            ->options([
                                'token' => 'Token Wallet',
                                'midtrans' => 'Gateway (Tokopay)',
                                'manual' => 'Manual Transfer'
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('total_price')
                            ->label('Total Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('token_used')
                            ->label('Token Digunakan')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\Select::make('status')
                            ->label('Status Order')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled'
                            ])
                            ->required(),
                        Forms\Components\DateTimePicker::make('estimated_finish')
                            ->label('Estimasi Selesai'),
                        Forms\Components\DateTimePicker::make('completed_at')
                            ->label('Waktu Selesai'),
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('Invoice')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Layanan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('paymentMethod.name')
                    ->label('Pembayaran')
                    ->sortable(),
               
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draf',
                        'waiting_payment' => 'Menunggu Pembayaran',
                        'paid' => 'Dibayar',
                        'queued' => 'Dalam Antrean',
                        'assigned' => 'Ditugaskan',
                        'processing' => 'Diproses',
                        'review' => 'Peninjauan',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        'expired' => 'Kedaluwarsa',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'waiting_payment' => 'warning',
                        'paid' => 'success',
                        'queued' => 'info',
                        'assigned' => 'primary',
                        'processing' => 'primary',
                        'review' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        'expired' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('upload_result')
                    ->label('Upload Hasil')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->form([
                        Forms\Components\FileUpload::make('result_file')
                            ->label('File Hasil Proses')
                            ->disk('public')
                            ->directory('checker_files')
                            ->preserveFilenames()
                            ->required(),
                        Forms\Components\TextInput::make('score')
                            ->label('Score / Nilai')
                            ->placeholder('Contoh: 15% atau 85 Score')
                            ->nullable(),
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Tambahan (Opsional)'),
                        Forms\Components\Select::make('status')
                            ->label('Update Status Order')
                            ->options([
                                'completed' => 'Selesai (Completed)',
                                'review' => 'Perlu Direview (Review)',
                            ])
                            ->default('completed')
                            ->required(),
                    ])
                    ->action(function (CheckerOrder $record, array $data): void {
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
                        
                        $updateData = ['status' => $data['status']];
                        
                        if (!empty($data['score'])) {
                            $updateData['score'] = $data['score'];
                        }
                        
                        $record->update($updateData);
                        
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
                    ->visible(fn (CheckerOrder $record) => !in_array($record->status, ['completed', 'cancelled'])),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(\Filament\Infolists\Infolist $infolist): \Filament\Infolists\Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Informasi Pesanan')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('invoice_number')->label('Invoice'),
                        \Filament\Infolists\Components\TextEntry::make('customer.name')->label('Customer'),
                        \Filament\Infolists\Components\TextEntry::make('service.name')->label('Layanan'),
                        \Filament\Infolists\Components\TextEntry::make('status')->badge(),
                        \Filament\Infolists\Components\TextEntry::make('total_price')->money('IDR', locale: 'id')->label('Total Harga'),
                        \Filament\Infolists\Components\TextEntry::make('created_at')->dateTime()->label('Tanggal Order'),
                    ])->columns(2),

                \Filament\Infolists\Components\Section::make('Inputan Teks User')
                    ->schema([
                        \Filament\Infolists\Components\RepeatableEntry::make('textAnswers')
                            ->label('')
                            ->schema([
                                \Filament\Infolists\Components\TextEntry::make('question.label')
                                    ->label('Pertanyaan / Field'),
                                \Filament\Infolists\Components\TextEntry::make('answer')
                                    ->label('Jawaban')
                                    ->formatStateUsing(function ($state, $record) {
                                        if ($record->question && $record->question->field_type === 'checkbox') {
                                            return in_array($state, ['1', 1, 'true', true], true) ? 'Iya' : 'Tidak';
                                        }
                                        return $state ?: '-';
                                    })
                            ])->columns(2),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\FilesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCheckerOrders::route('/'),
            'create' => Pages\CreateCheckerOrder::route('/create'),
            'view' => Pages\ViewCheckerOrder::route('/{record}'),
            'edit' => Pages\EditCheckerOrder::route('/{record}/edit'),
        ];
    }
}
