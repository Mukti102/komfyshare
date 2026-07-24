<?php

namespace App\Filament\Resources\CheckerNotificationResource\Pages;

use App\Filament\Resources\CheckerNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckerNotification extends EditRecord
{
    protected static string $resource = CheckerNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
