<?php

namespace App\Filament\Resources\CheckerPackageResource\Pages;

use App\Filament\Resources\CheckerPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckerPackage extends EditRecord
{
    protected static string $resource = CheckerPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
