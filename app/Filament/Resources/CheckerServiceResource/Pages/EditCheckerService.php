<?php

namespace App\Filament\Resources\CheckerServiceResource\Pages;

use App\Filament\Resources\CheckerServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckerService extends EditRecord
{
    protected static string $resource = CheckerServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
