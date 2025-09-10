<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentMetodsResource\Pages;
use App\Filament\Resources\PaymentMetodsResource\RelationManagers;
use App\Models\PaymentMetods;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentMetodsResource extends Resource
{
    protected static ?string $model = PaymentMetods::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Metode Pembayaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('code')
                    ->label('Kode')
                    ->required()
                    ->maxLength(255),
                 Forms\Components\Select::make('category')
                ->label('Kategory')
                 ->options([
                    'Virtual Account' => 'Virtual Account',
                    'Emoney' => 'Emoney',
                    'QRIS' => 'QRIS',
                    'Retail' => 'Retail',
                    'Pulsa' => 'Pulsa'
                 ]),
                Forms\Components\FileUpload::make('logo')
                    ->disk('public')
                    ->imageEditor()
                    ->directory('payment_method')
                    ->required(),
                // Forms\Components\TextInput::make('owner')
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('nomor_rek')
                //     ->maxLength(255),
                // Forms\Components\FileUpload::make('image')
                //     ->label('Gambar No Rekening/Qris (Opsional)')
                //     ->disk('public')
                //     ->directory('payment_method')
                //     ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('logo')
                    ->searchable(),
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPaymentMetods::route('/'),
            'create' => Pages\CreatePaymentMetods::route('/create'),
            'edit' => Pages\EditPaymentMetods::route('/{record}/edit'),
        ];
    }
}
