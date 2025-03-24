<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProviderResource\Pages;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProviderResource extends Resource
{
    protected static ?string $model = Provider::class;

    protected static ?string $modelLabel = 'Proveedor';
    protected static ?string $pluralModelLabel = 'Proveedores';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::End;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('node', function (Builder $query) {
                $query
                    // Current user as Node creator
                    ->where('user_id', '=', auth()->id())
                    // Or current user as Node consumer
                    ->orWhereHas('consumers', function (Builder $query) {
                        $query->where('user_id', '=', auth()->id());
                    });
            });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('contact')
                    ->label('Contacto')
                    ->helperText('Nombre de contacto en el proveedor')
                    ->required(),
                Forms\Components\Select::make('node_id')
                    ->label('Nodo')
                    ->relationship('node', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('contact')
                    ->label('Contacto')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('node.name')
                    ->label('Nodo')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('products_count')
                    ->label('Productos')
                    ->counts('products'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('node')
                    ->label('Nodo')
                    ->relationship('node', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\Action::make('products')
                    ->label('Productos')
                    ->link()
                    ->url(function (Tables\Actions\Action $action) {
                        // ...
                        // dd($arguments, $action);
                        return 'providers/'.$action->getRecord()->id.'/products';
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            // ...
            Pages\ManageProviderProducts::class,
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProviders::route('/'),
            'create' => Pages\CreateProvider::route('/create'),
            'edit' => Pages\EditProvider::route('/{record}/edit'),
            'products' => Pages\ManageProviderProducts::route('/{record}/products'),
        ];
    }
}
