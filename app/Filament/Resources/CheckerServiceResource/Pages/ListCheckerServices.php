<?php

namespace App\Filament\Resources\CheckerServiceResource\Pages;

use App\Filament\Resources\CheckerServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCheckerServices extends ListRecords
{
    protected static string $resource = CheckerServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
