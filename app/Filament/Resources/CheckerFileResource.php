<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckerFileResource\Pages;
use App\Filament\Resources\CheckerFileResource\RelationManagers;
use App\Models\CheckerFile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CheckerFileResource extends Resource
{
    protected static ?string $model = CheckerFile::class;

    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Komfy Checker / Transactions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('File Details')
                    ->schema([
                        Forms\Components\Select::make('checker_order_id')
                            ->label('Order (Invoice)')
                            ->relationship('order', 'invoice_number')
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('category')
                            ->label('Kategori')
                            ->required(),
                        Forms\Components\FileUpload::make('file_path')
                            ->label('Upload File')
                            ->disk('public')
                            ->directory('checker_files')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('original_name')
                            ->label('Nama Asli File')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('file_name')
                            ->label('Nama File (Sistem)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('extension')
                            ->label('Ekstensi')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('mime_type')
                            ->label('MIME Type')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('file_size')
                            ->label('Ukuran File (Bytes)')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('uploaded_by')
                            ->label('Diupload Oleh')
                            ->required(),
                        Forms\Components\DateTimePicker::make('uploaded_at')
                            ->label('Waktu Upload'),
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
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('original_name')
                    ->label('Nama File')
                    ->searchable(),
                Tables\Columns\TextColumn::make('extension')
                    ->label('Ext')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_size')
                    ->label('Ukuran')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('uploaded_by')
                    ->label('Uploader'),
                Tables\Columns\TextColumn::make('uploaded_at')
                    ->label('Diupload')
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
            'index' => Pages\ListCheckerFiles::route('/'),
            'create' => Pages\CreateCheckerFile::route('/create'),
            'edit' => Pages\EditCheckerFile::route('/{record}/edit'),
        ];
    }
}
