<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckerServiceResource\Pages;
use App\Filament\Resources\CheckerServiceResource\RelationManagers;
use App\Models\CheckerService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CheckerServiceResource extends Resource
{
    protected static ?string $model = CheckerService::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Komfy Checker / Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Service Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('icon')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('price')
                            ->label('Harga (Rp)')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Forms\Components\TextInput::make('base_price')
                            ->label('Harga Dasar (Rp)')
                            ->helperText('Harga dasar layanan. Selalu ditambahkan ke total harga pesanan.')
                            ->numeric()
                            ->default(0)
                            ->prefix('Rp')
                            ->required(),
                        Forms\Components\TextInput::make('estimated_hours')
                            ->numeric()
                            ->suffix('Hours'),
                        Forms\Components\ColorPicker::make('color'),
                        Forms\Components\TextInput::make('badge')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull(),
                    ])->columns(2),
                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_token_available')
                            ->required(),
                        Forms\Components\Toggle::make('status')
                            ->required(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_token_available')
                    ->label("Token Tersedia")
                    ->boolean(),
                Tables\Columns\IconColumn::make('status')
                    ->label("Status")
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label("Urutan")
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('badge')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Dibuat Pada")
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
            'index' => Pages\ListCheckerServices::route('/'),
            'create' => Pages\CreateCheckerService::route('/create'),
            'edit' => Pages\EditCheckerService::route('/{record}/edit'),
        ];
    }
}
