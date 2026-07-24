<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckerPackageResource\Pages;
use App\Filament\Resources\CheckerPackageResource\RelationManagers;
use App\Models\CheckerPackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CheckerPackageResource extends Resource
{
    protected static ?string $model = CheckerPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Komfy Checker / Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Package Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Paket')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('price')
                            ->label('Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('total_token')
                            ->label('Jumlah Token')
                            ->required()
                            ->suffix(' Token')
                            ->numeric(),
                        Forms\Components\TextInput::make('expired_day')
                            ->label('Masa Aktif (Hari)')
                            ->required()
                            ->suffix(' Hari')
                            ->numeric(),
                        Forms\Components\Toggle::make('status')
                            ->label('Status')
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_token')
                    ->label('Jumlah Token')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expired_day')
                    ->label('Masa Aktif (Hari)')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
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
            'index' => Pages\ListCheckerPackages::route('/'),
            'create' => Pages\CreateCheckerPackage::route('/create'),
            'edit' => Pages\EditCheckerPackage::route('/{record}/edit'),
        ];
    }
}
