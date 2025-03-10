<?php

namespace App\Filament\Pages;

use BlogSettings;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageBlogSettings extends SettingsPage
{
    protected static ?string $navigationGroup = 'Ajustes';

    protected static ?string $navigationLabel = 'Blog';

    protected static ?string $title = 'Ajustes del Blog';

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static string $settings = BlogSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Paginación')
                    // ->description('Prevent abuse by limiting the number of requests per period')
                    ->schema([
                        TextInput::make('postPerPage')
                            ->label('Posts por página')
                            ->integer()
                            ->minValue(1)
                            ->required()
                            ->inputMode('numeric'),
                        TextInput::make('pageOnEachSide')
                            ->label('Botones a cada lado de página actual')
                            ->integer()
                            ->minValue(1)
                            ->required()
                            ->inputMode('numeric'),
                    ]),
            ]);
    }
}
