<?php

namespace App\Filament\Resources\CheckerQuestionOptionResource\Pages;

use App\Filament\Resources\CheckerQuestionOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckerQuestionOption extends EditRecord
{
    protected static string $resource = CheckerQuestionOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
