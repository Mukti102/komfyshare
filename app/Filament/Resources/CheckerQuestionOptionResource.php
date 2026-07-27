<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CheckerQuestionOptionResource\Pages;
use App\Filament\Resources\CheckerQuestionOptionResource\RelationManagers;
use App\Models\CheckerQuestionOption;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CheckerQuestionOptionResource extends Resource
{
    protected static ?string $model = CheckerQuestionOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = 'Komfy Checker / Master';
    protected static ? string $navigationLabel = "Opsi Pertanyaan Checker";

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Opsi')
                    ->description('Detail opsi jawaban untuk pertanyaan terkait.')
                    ->schema([
                        Forms\Components\Select::make('checker_question_id')
                            ->label('Pertanyaan Terkait')
                            ->relationship('question', 'label')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('label')
                            ->label('Label (Tampilan)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Misal: Kertas A4 / Cepat'),
                        Forms\Components\TextInput::make('value')
                            ->label('Nilai (Value)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Sistem value, misal: a4 / fast'),
                        Forms\Components\TextInput::make('additional_price')
                            ->label('Harga Tambahan (Rp)')
                            ->helperText('Nominal ini akan ditambahkan ke total harga jika customer memilih opsi ini.')
                            ->required()
                            ->numeric()
                            ->default(0.00)
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question.label')
                    ->label('Pertanyaan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('label')
                    ->label('Label Opsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai')
                    ->searchable()
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('additional_price')
                    ->label('Tambahan Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
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
            'index' => Pages\ListCheckerQuestionOptions::route('/'),
            'create' => Pages\CreateCheckerQuestionOption::route('/create'),
            'edit' => Pages\EditCheckerQuestionOption::route('/{record}/edit'),
        ];
    }
}
