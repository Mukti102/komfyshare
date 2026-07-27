<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckerCouponResource\Pages;
use App\Filament\Resources\CheckerCouponResource\RelationManagers;
use App\Models\CheckerCoupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CheckerCouponResource extends Resource
{
    protected static ?string $model = CheckerCoupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Komfy Checker / Master';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->label('Kode Promo'),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->label('Total Stok'),
                Forms\Components\TextInput::make('sisa_stock')
                    ->required()
                    ->numeric()
                    ->label('Sisa Stok'),
                Forms\Components\TextInput::make('percentase_discount')
                    ->numeric()
                    ->label('Diskon Persen (%)')
                    ->suffix('%')
                    ->maxValue(100),
                Forms\Components\TextInput::make('rupiah_discount')
                    ->numeric()
                    ->label('Diskon Nominal (Rp)')
                    ->prefix('Rp'),
                Forms\Components\DatePicker::make('expired_date')
                    ->label('Tanggal Berakhir'),
                Forms\Components\Toggle::make('status')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->label('Kode Promo'),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable()
                    ->label('Stok'),
                Tables\Columns\TextColumn::make('sisa_stock')
                    ->numeric()
                    ->sortable()
                    ->label('Sisa'),
                Tables\Columns\TextColumn::make('percentase_discount')
                    ->numeric()
                    ->suffix('%')
                    ->label('Diskon (%)'),
                Tables\Columns\TextColumn::make('rupiah_discount')
                    ->money('IDR')
                    ->label('Diskon (Rp)'),
                Tables\Columns\TextColumn::make('expired_date')
                    ->date()
                    ->sortable()
                    ->label('Berakhir'),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
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
            'index' => Pages\ListCheckerCoupons::route('/'),
            'create' => Pages\CreateCheckerCoupon::route('/create'),
            'edit' => Pages\EditCheckerCoupon::route('/{record}/edit'),
        ];
    }
}
