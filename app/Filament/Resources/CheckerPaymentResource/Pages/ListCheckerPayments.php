<?php

namespace App\Filament\Resources\CheckerPaymentResource\Pages;

use App\Filament\Resources\CheckerPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCheckerPayments extends ListRecords
{
    protected static string $resource = CheckerPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
