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
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


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
                            ->required()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('thumbnails'),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('images')
                            ->required(),
                        Repeater::make('prices')
                            ->relationship('prices')
                            ->schema([
                                TextInput::make('duration')
                                    ->label('Name')
                                    ->placeholder('Durasi (misal: 1 Bulan, 3 Bulan, 1 Tahun)')
                                    ->required(),
                                TextInput::make('price')
                                    ->label('Harga')
                                    ->placeholder('100000')
                                    ->prefix('Rp ')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('duration_day')
                                    ->label('Durasi')
                                    ->placeholder('30')
                                    ->suffix('Hari')
                                    ->numeric(),
                                Toggle::make('status')
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
                            ->required(),
                        Forms\Components\RichEditor::make('description')
                            ->label('Schema Berlangganan')
                            ->required(),
                        Forms\Components\RichEditor::make('information')
                            ->label('Informasi')
                            ->nullable()
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
