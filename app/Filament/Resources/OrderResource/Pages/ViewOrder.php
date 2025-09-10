<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    // cukup set property ini — jangan buat method getView()
    protected static string $view = 'filament.resources.order-resource.pages.view-order';

    public function getTitle(): string
    {
        return 'Detail Order';
    }
}
