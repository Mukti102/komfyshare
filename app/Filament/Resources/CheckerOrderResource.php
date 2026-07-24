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
