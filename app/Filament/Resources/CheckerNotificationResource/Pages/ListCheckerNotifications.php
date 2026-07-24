<?php

namespace App\Filament\Resources\CheckerNotificationResource\Pages;

use App\Filament\Resources\CheckerNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCheckerNotifications extends ListRecords
{
    protected static string $resource = CheckerNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
