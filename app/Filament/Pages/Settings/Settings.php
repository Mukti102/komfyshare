<?php

namespace App\Filament\Pages\Settings;
 
use Closure;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Outerweb\FilamentSettings\Filament\Pages\Settings as BaseSettings;
 
class Settings extends BaseSettings
{   

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 8;

    

    public function schema(): array|Closure
    {
        return [
            Tabs::make('Settings')
                ->schema([
                    Tabs\Tab::make('General')
                        ->schema([
                            TextInput::make('general.brand_name')
                                ->required(),
                            TextInput::make('general.email')
                            ->email(),
                            TextInput::make('general.phone')
                            ->tel(),
                        ])->columns(2),
                    Tabs\Tab::make('Seo')
                        ->schema([
                            TextInput::make('seo.title')
                                ->required(),
                            TextInput::make('seo.description')
                                ->required(),
                        ])->columns(2),
                ]),
        ];
    }
}