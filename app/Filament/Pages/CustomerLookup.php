<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class CustomerLookup extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Komfy Checker / Transactions';

    protected static string $view = 'filament.pages.customer-lookup';
}
