<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CostumerResource;
use App\Filament\Resources\CostumerResource\Pages\Costumer;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Pages\CreateOrder;
use App\Filament\Resources\OrderResource\Pages\EditOrder;
use App\Filament\Resources\OrderResource\Pages\ListOrders;
use App\Filament\Resources\OrderResource\Pages\ViewOrder;
use App\Models\Order;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Pages\Actions\Action; // <-- IMPORT YANG PENTING


class ViewCostumer extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $resource = CostumerResource::class;

    protected static string $view = 'filament.resources.costumer-resource.pages.view-costumer';

    public $record; // ini id customer

    protected function getHeaderActions(): array
    {
        return [
            Action::make('createOrder')
                ->label('Tambah Order')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->url(fn(): string => OrderResource::getUrl('create', [
                    'costumer_id' => $this->record, // biar otomatis terisi
                ])),
        ];
    }

    public function mount($record)
    {
        $this->record = $record;
    }

    public function getTitle(): string
    {
        return 'List Order';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()->where('costumer_id', $this->record) // hanya ambil order milik customer ini
            )
            ->columns([
                Tables\Columns\TextColumn::make('product.title')->label('Produk'),
                Tables\Columns\TextColumn::make('invoice')->label('Invoice')->searchable(),
                Tables\Columns\TextColumn::make('amount')->label('Jumlah'),
                Tables\Columns\TextColumn::make('productPrice.duration_day')->label('Durasi Hari'),
                Tables\Columns\TextColumn::make('start_date')->date('d F Y')->label('Tanggal Awal'),
                Tables\Columns\TextColumn::make('end_date')->date('d F Y')->label('Tanggal Akhir'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'pending' => 'warning',
                        'completed' => 'success',
                        'canceled' => 'danger',
                        default => 'secondary',
                    }),
            ])->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Edit')
                    ->button()
                    ->color('warning')
                    ->icon('heroicon-o-pencil')
                    ->url(fn(Order $record): string => OrderResource::getUrl('edit', ['record' => $record])),

                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->button()
                    ->color('primary')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Order $record): string => OrderResource::getUrl('view', ['record' => $record])),
            ])
        ;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
            'view' => ViewOrder::route('/{record}'),
        ];
    }
}
