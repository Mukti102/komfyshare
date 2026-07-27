<?php

namespace App\Filament\Resources\CheckerTestimonialResource\Pages;

use App\Filament\Resources\CheckerTestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCheckerTestimonial extends EditRecord
{
    protected static string $resource = CheckerTestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
