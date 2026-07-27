<?php

namespace App\Filament\Resources\CheckerCouponResource\Pages;

use App\Filament\Resources\CheckerCouponResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckerCoupon extends EditRecord
{
    protected static string $resource = CheckerCouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
