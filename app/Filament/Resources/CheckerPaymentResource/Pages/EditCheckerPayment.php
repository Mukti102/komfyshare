<?php

namespace App\Filament\Resources\CheckerPaymentResource\Pages;

use App\Filament\Resources\CheckerPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckerPayment extends EditRecord
{
    protected static string $resource = CheckerPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
