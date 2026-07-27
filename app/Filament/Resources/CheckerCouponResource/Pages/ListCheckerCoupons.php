<?php

namespace App\Filament\Resources\CheckerCouponResource\Pages;

use App\Filament\Resources\CheckerCouponResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCheckerCoupons extends ListRecords
{
    protected static string $resource = CheckerCouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
