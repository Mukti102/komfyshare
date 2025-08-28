<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Product Details')
                    ->schema([
                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('subtitle')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('tagline')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TagsInput::make('listOfBenefits')
                            ->label('Semua Paket Mencakup')
                            ->required(),
                        Forms\Components\FileUpload::make('thumbnail')
                            ->imageEditor()
                            ->disk('public')
                            ->directory('thumbnails')
                            ->maxSize(2024) // 1MB
                            ->required(),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('images')
                            ->maxSize(2024) // 1MB
                            ->required(),
                        Repeater::make('prices')
                            ->relationship('prices')
                            ->schema([
                                TextInput::make('duration')
                                ->label('Durasi')
                                ->placeholder('Durasi (misal: 1 Bulan, 3 Bulan, 1 Tahun)')
                                ->required(),
                                TextInput::make('price')
                                ->label('Harga')
                                ->placeholder('100000')
                                ->prefix('Rp ')
                                ->numeric()
                                ->required(),
                            ])
                            ->columns(2),
                        Forms\Components\TextInput::make('discount')
                            ->integer()
                            ->placeholder('10')
                            ->suffix('%')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('status')
                            ->helperText('Jika non-aktif, produk tidak akan muncul di halaman depan.')
                            ->required(),
                        Forms\Components\RichEditor::make('priceDetails')
                            ->label('Detail Harga')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description')
                            ->label('Schema Berlangganan')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('discount')
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
