<?php

namespace App\Filament\Pages\Settings;

use Closure;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
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
                            FileUpload::make('general.logo')
                                ->disk('public')
                                ->directory('setting')
                                ->maxSize(2024),
                            FileUpload::make('general.favicon')
                                ->disk('public')
                                ->directory('setting')
                                ->maxSize(2024),
                        ])->columns(2),
                    Tabs\Tab::make('Seo')
                        ->schema([
                            TextInput::make('seo.title')
                                ->required(),
                            TextInput::make('seo.description')
                                ->required(),
                        ])->columns(2),
                    Tabs\Tab::make('Jam Operasional')
                        ->schema([
                            TextInput::make('operational.text')
                                ->required(),
                            TimePicker::make('operational.start-time')
                                ->required(),
                            TimePicker::make('operational.end-time')
                                ->required(),
                        ])->columns(2),
                    Tabs\Tab::make('Poster')
                        ->schema([
                            Repeater::make('poster')
                                ->schema([
                                    FileUpload::make('poster')
                                        ->maxSize(2024)
                                        ->disk('public')
                                        ->imageEditor()
                                        ->directory('poster'),
                                ])
                        ]),
                    Tabs\Tab::make('Poster Mobile')
                        ->schema([
                            Repeater::make('poster_mobile')
                                ->schema([
                                    FileUpload::make('poster')
                                        ->maxSize(2024)
                                        ->imageEditor()
                                        ->disk('public')
                                        ->directory('poster'),
                                ])
                        ]),
                    Tabs\Tab::make('kebijakan_privasi')
                        ->schema([
                            RichEditor::make('term.use')
                                ->label('Syarat Dan Ketentuan'),
                            RichEditor::make('term.privasi')
                                ->label('Kebijakan Privasi'),
                        ]),
                    Tabs\Tab::make('Sosial Media')
                        ->schema([
                            TextInput::make('sosialMedia.facebook'),
                            TextInput::make('sosialMedia.instagram'),
                            TextInput::make('sosialMedia.whatsaap')
                            ->placeholder('628***')
                            ->tel(),
                        ])->columns(2),
                ]),
        ];
    }
}
