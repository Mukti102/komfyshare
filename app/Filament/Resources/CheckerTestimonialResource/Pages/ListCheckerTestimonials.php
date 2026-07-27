<?php

namespace App\Filament\Resources\CheckerTestimonialResource\Pages;

use App\Filament\Resources\CheckerTestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCheckerTestimonials extends ListRecords
{
    protected static string $resource = CheckerTestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
