<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckerQuestionResource\Pages;
use App\Models\CheckerQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CheckerQuestionResource extends Resource
{
    protected static ?string $model = CheckerQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'Komfy Checker / Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Question Details')
                    ->schema([
                        Forms\Components\Select::make('checker_service_id')
                            ->relationship('service', 'name')
                            ->searchable()
                            ->required()
                            ->label('Layanan'),
                        Forms\Components\TextInput::make('label')
                            ->label('Label')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('field_name')
                            ->label('Field')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('field_type')
                            ->label('Tipe')
                            ->options([
                                'text' => 'Text Input',
                                'textarea' => 'Textarea',
                                'number' => 'Number Input',
                                'date' => 'Date Picker',
                                'file' => 'File Upload',
                                'select' => 'Dropdown Select',
                                'checkbox' => 'Checkbox',
                                'radio' => 'Radio Button',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('validation')
                            ->maxLength(255)
                            ->placeholder('e.g., required|numeric|max:255'),
                        Forms\Components\TextInput::make('placeholder')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_required')
                            ->label('Wajib diisi')
                            ->required(),
                        Forms\Components\Textarea::make('help_text')
                            ->label('Keterangan')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Pengaturan Harga')
                    ->description('Konfigurasi bagaimana pertanyaan ini mempengaruhi harga pesanan.')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        Forms\Components\Toggle::make('affects_price')
                            ->label('Mempengaruhi Harga?')
                            ->helperText('Aktifkan jika jawaban pertanyaan ini harus diperhitungkan dalam total harga.')
                            ->live()
                            ->default(false),
                        Forms\Components\Select::make('pricing_rule')
                            ->label('Aturan Harga')
                            ->options([
                                'per_file'  => 'Per File Upload — jumlah file × harga satuan',
                                'multiply'  => 'Kalikan dengan Input — nilai input × harga satuan',
                                'option'    => 'Sesuai Pilihan Opsi — ambil dari additional_price opsi',
                            ])
                            ->visible(fn (Get $get): bool => (bool) $get('affects_price'))
                            ->required(fn (Get $get): bool => (bool) $get('affects_price'))
                            ->live(),
                        Forms\Components\TextInput::make('unit_price')
                            ->label('Harga Satuan (Rp)')
                            ->helperText('Harga per unit. Digunakan untuk rule Per File dan Kalikan.')
                            ->numeric()
                            ->default(0)
                            ->prefix('Rp')
                            ->visible(fn (Get $get): bool => (bool) $get('affects_price') && in_array($get('pricing_rule'), ['per_file', 'multiply']))
                            ->required(fn (Get $get): bool => in_array($get('pricing_rule'), ['per_file', 'multiply'])),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Layanan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('label')
                    ->label('Pertanyaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('field_type')
                    ->label('Tipe Input')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\IconColumn::make('affects_price')
                    ->label('Harga?')
                    ->boolean(),
                Tables\Columns\TextColumn::make('pricing_rule')
                    ->label('Aturan')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'none' => 'Tidak Ada',
                        'per_file' => 'Per File',
                        'multiply' => 'Kalikan',
                        'option' => 'Opsi',
                        default => $state ?? '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'per_file' => 'info',
                        'multiply' => 'warning',
                        'option' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('unit_price')
                    ->label('Harga Satuan')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_required')
                    ->label('Wajib')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListCheckerQuestions::route('/'),
            'create' => Pages\CreateCheckerQuestion::route('/create'),
            'edit' => Pages\EditCheckerQuestion::route('/{record}/edit'),
        ];
    }
}
