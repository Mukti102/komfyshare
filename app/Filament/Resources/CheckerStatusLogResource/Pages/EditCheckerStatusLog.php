<?php

namespace App\Filament\Resources\CheckerStatusLogResource\Pages;

use App\Filament\Resources\CheckerStatusLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckerStatusLog extends EditRecord
{
    protected static string $resource = CheckerStatusLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
