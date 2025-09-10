<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Jobs\SendWhatsapp;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Order Information')
                    ->description('Provide the order details.')
                    ->schema([
                        Forms\Components\Select::make('costumer_id')
                            ->relationship('costumer', 'name')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('product_id')
                            ->relationship('product', 'title')
                            ->searchable()
                            ->reactive()
                            ->required(),
                        Forms\Components\Select::make('product_price_id')
                            ->label('Harga')
                            ->options(function (callable $get) {
                                $productId = $get('product_id');
                                if (! $productId) {
                                    return [];
                                }

                                return \App\Models\ProductPrice::where('product_id', $productId)
                                    ->get()
                                    ->mapWithKeys(fn($price) => [
                                        $price->id => $price->duration . ' - Rp ' . number_format($price->price, 0, ',', '.'),
                                    ]);
                            })
                            ->reactive()
                            ->required()
                            ->disabled(fn(callable $get) => ! $get('product_id')),

                        Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah')
                            ->numeric()
                            ->default(1)
                            ->suffix('Slot')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $priceId = $get('product_price_id');
                                if ($priceId) {
                                    $price = \App\Models\ProductPrice::find($priceId);
                                    if ($price) {
                                        $set('amount', $state * $price->price);
                                    }
                                }
                            })
                            ->required(),
                        Forms\Components\Select::make('payment_metod_id')
                            ->label('Metode Pembayaran')
                            ->relationship('paymentMethod', 'name')
                            ->required(),

                        Forms\Components\TextInput::make('amount')
                            ->label('Total Harga')
                            ->numeric()
                            ->disabled() // user tidak bisa edit manual
                            ->dehydrated(true) // tetap disimpan ke DB
                            ->reactive()
                            ->afterStateHydrated(function (callable $set, callable $get) {
                                $priceId = $get('product_price_id');
                                $quantity = $get('quantity') ?? 1;

                                if ($priceId) {
                                    $price = \App\Models\ProductPrice::find($priceId);
                                    if ($price) {
                                        $set('amount', $quantity * $price->price);
                                    }
                                }
                            })
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // kalau ada perubahan di product_price_id, juga update amount
                                $priceId = $state;
                                $quantity = $get('quantity') ?? 1;

                                if ($priceId) {
                                    $price = \App\Models\ProductPrice::find($priceId);
                                    if ($price) {
                                        $set('amount', $quantity * $price->price);
                                    }
                                }
                            }),


                        Forms\Components\TextInput::make('invoice')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('start_date')
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => "Pending",
                                'completed' => 'Complete',
                                'canceled' => 'Canceled'
                            ])
                            ->required(),
                        Forms\Components\FileUpload::make('payment_proof')
                            ->disk('public')
                            ->directory('proof')
                            ->maxSize(2025),
                        Forms\Components\Textarea::make('notes')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->latest('created_at');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('costumer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice')
                    ->label('Invoice')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('productPrice.duration_day')
                    ->label('Durasi Hari')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tanggal Awal')
                    ->date('d F Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tanggal Akhir')
                    ->date('d F Y')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge() // tetap pakai badge untuk membuat kotak
                    ->color(fn($state) => match ($state) {
                        'pending' => 'warning',
                        'completed' => 'success',
                        'canceled' => 'danger',
                        default => 'secondary',
                    })
                    ->sortable()
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
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->button()
                    ->color('primary')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Order $record): string => static::getUrl('view', ['record' => $record])),
                Tables\Actions\EditAction::make()
                    ->button()
                    ->color('warning'),
                Tables\Actions\Action::make('updateStatus')
                    ->label('Status')
                    ->icon('heroicon-o-arrows-right-left')
                    ->color('info')
                    ->button()
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Pilih Status')
                            ->options([
                                'pending' => 'Pending',
                                'completed' => 'Complete',
                                'canceled' => 'Canceled',
                            ])
                            ->required(),
                    ])
                    ->action(function (array $data, Order $record): void {
                        $record->update([
                            'status' => $data['status'],
                        ]);

                        if ($data['status'] === 'completed') {
                            $product = $record->product; // relasi order -> product
                            $groups = $product->groups;  // relasi product -> groups (Collection)

                            if ($groups->isNotEmpty()) {
                                // pilih group pertama yang masih punya slot kosong
                                $group = $groups->firstWhere(fn($g) => $g->slots()->count() < $g->max_slot);

                                if ($group) {
                                    $group->slots()->create([
                                        'order_id'    => $record->id,
                                        'group_id'    => $group->id,
                                        'costumer_id' => $record->costumer_id,
                                    ]);

                                    // send whatsapp
                                    SendWhatsapp::dispatch($record->costumer->phone, 'Pesanan Anda Sudah Aktif dengan sampai tanggal' . $group->expired_date . 'silahkan akses akun anda email:' . $group->email . 'password:' . $group->password . 'di' . $group->product->name);


                                    // show notification
                                    Notification::make()
                                        ->title('Slot berhasil ditambahkan')
                                        ->success()
                                        ->send();
                                } else {
                                    Notification::make()
                                        ->title("Semua group untuk produk {$product->id} sudah penuh.")
                                        ->danger()
                                        ->send();
                                }
                            }
                        }
                    }),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
