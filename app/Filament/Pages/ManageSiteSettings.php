<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use GeneralSiteSettings;

class ManageSiteSettings extends SettingsPage
{
    use HasPageShield;

    protected static ?string $navigationGroup = 'Ajustes';

    protected static ?string $navigationLabel = 'Sitio';

    protected static ?string $title = 'Ajustes del sitio';

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSiteSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General')
                    // ->description('Prevent abuse by limiting the number of requests per period')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre del sitio')
                            ->required(),
                    ]),
                Section::make('SEO')
                    // ->description('Prevent abuse by limiting the number of requests per period')
                    ->schema([
                        TextInput::make('description')
                            ->label('Descripción'),
                        TextInput::make('keywords')
                            ->label('Palabras clave')
                            ->helperText('Ingresar palabras separadas por coma.'),
                    ]),
            ]);
    }
}
