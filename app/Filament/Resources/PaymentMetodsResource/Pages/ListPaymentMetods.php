<?php

namespace App\Filament\Resources\PaymentMetodsResource\Pages;

use App\Filament\Resources\PaymentMetodsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPaymentMetods extends ListRecords
{
    protected static string $resource = PaymentMetodsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
