<?php

namespace App\Filament\Widgets;

use App\Models\CheckerOrder;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class CheckerRecentOrdersWidget extends BaseWidget
{
    protected static ?int $sort = 6;

    public function getColumnSpan(): int|string|array
    {
        return 1;
    }

    protected static ?string $heading = 'Pesanan KomfyChecker Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                CheckerOrder::query()->latest()
            )
            ->defaultPaginationPageOption(5)
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()
                    ->label('Invoice'),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('IDR', locale: 'id')
                    ->label('Total'),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Tanggal'),
            ]);
    }
}
