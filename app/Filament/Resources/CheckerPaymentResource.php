<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckerPaymentResource\Pages;
use App\Filament\Resources\CheckerPaymentResource\RelationManagers;
use App\Models\CheckerPayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CheckerPaymentResource extends Resource
{
    protected static ?string $model = CheckerPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Komfy Checker / Transactions';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payment Details')
                    ->schema([
                        Forms\Components\Select::make('checker_order_id')
                            ->label('Order (Invoice)')
                            ->relationship('order', 'invoice_number')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('payment_method_id')
                            ->label('Metode Pembayaran')
                            ->relationship('paymentMethod', 'name')
                            ->searchable(),
                        Forms\Components\TextInput::make('transaction_code')
                            ->label('Kode Transaksi')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('gateway')
                            ->label('Gateway (Vendor)'),
                        Forms\Components\TextInput::make('amount')
                            ->label('Jumlah')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('admin_fee')
                            ->label('Biaya Admin')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0.00),
                        Forms\Components\TextInput::make('total_amount')
                            ->label('Total Pembayaran')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('payment_status')
                            ->label('Status Pembayaran')
                            ->required(),
                        Forms\Components\DateTimePicker::make('paid_at')
                            ->label('Waktu Dibayar'),
                        Forms\Components\DateTimePicker::make('expired_at')
                            ->label('Waktu Kedaluwarsa'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.invoice_number')
                    ->label('Invoice')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('paymentMethod.name')
                    ->label('Metode')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('transaction_code')
                    ->label('Kode TRX')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gateway')
                    ->label('Gateway'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('admin_fee')
                    ->label('Biaya Admin')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Status')
                    ->badge(),
                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Dibayar')
                    ->dateTime()
                    ->sortable(),
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
                // Read Only
            ])
            ->bulkActions([
                // Read Only
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCheckerPayments::route('/'),
        ];
    }
}
