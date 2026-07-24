<?php

namespace App\Filament\Resources\CheckerOrderResource\Pages;

use App\Filament\Resources\CheckerOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCheckerOrders extends ListRecords
{
    protected static string $resource = CheckerOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
