<?php

namespace App\Filament\Resources\CheckerFileResource\Pages;

use App\Filament\Resources\CheckerFileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckerFile extends EditRecord
{
    protected static string $resource = CheckerFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
