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
                    Tabs\Tab::make('Popup')
                        ->schema([
                            FileUpload::make('popup.information')
                                ->label('Gambar Popup Informasi')
                                ->imageEditor()
                                ->disk('public')
                                ->directory('popup'),
                            FileUpload::make('popup.costumer.support')
                                ->label('Gambar Popup Costumer Support')
                                ->imageEditor()
                                ->disk('public')
                                ->directory('popup'),
                        ])->columns(2),
                    Tabs\Tab::make('Secret Key')
                        ->icon('heroicon-o-key')
                        ->schema([
                            TextInput::make('tokopay.api_key')
                            ->label('TOKOPAY API KEY'),
                            TextInput::make('tokopay.merchant_id')
                            ->label('TOKOPAY MERCHANT ID'),
                            TextInput::make('wablas.token')
                            ->label('TOKEN WABLAS'),
                            TextInput::make('wablas.secret_key')
                            ->label('SECRET KEY WABLAS'),
                            TextInput::make('wablas.base_url')
                            ->label('BASE URL')
                            ->placeholder('https://texas.wablas.com/api/send-message')
                            ,
                        ])->columns(2),
                ]),
        ];
    }
}
