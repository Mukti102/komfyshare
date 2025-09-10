<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Kupon')
                    ->description('Kupon Discount Untuk Mendapatkan Potongan Harga')
                    ->schema([

                        Forms\Components\TextInput::make('code')
                            ->helperText('Disarankan Menggukan Huruf Kapital')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('stock')
                            ->helperText('Jumlah Batasan Kupon Bisa Di Gunakan')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('sisa_stock')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('percentase_discount')
                            ->numeric()
                            ->suffix('%')
                            ->required()
                            ->maxLength(255),
                        // Forms\Components\TextInput::make('rupiah_discount')
                        //     ->prefix('Rp')
                        //     ->maxLength(255),
                        Forms\Components\Toggle::make('status')
                            ->helperText('Jika No Active Maka Kupon Tidak Bisa Di Gunakan')
                            ->required(),
                        Forms\Components\DatePicker::make('expired_date')
                            ->label('Tanggal Batas Akhir'),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sisa_stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('percentase_discount')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rupiah_discount')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
