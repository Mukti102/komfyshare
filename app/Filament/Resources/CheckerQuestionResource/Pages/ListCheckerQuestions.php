<?php

namespace App\Filament\Resources\CheckerQuestionResource\Pages;

use App\Filament\Resources\CheckerQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCheckerQuestions extends ListRecords
{
    protected static string $resource = CheckerQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
