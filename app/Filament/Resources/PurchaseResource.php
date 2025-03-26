<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Filament\Resources\PurchaseResource\RelationManagers;
use App\Models\Purchase;
use App\PurchaseState;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component as Livewire;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

    protected static ?string $modelLabel = 'Compra';
    protected static ?string $pluralModelLabel = 'Compras';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::End;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('node_id')
                    ->translateLabel()
                    ->relationship('node', 'name', function (Builder $query) {
                        $query
                            // Current user as Node creator
                            ->where('user_id', '=', auth()->id())
                            // Or current user as Node consumer
                            ->orWhereHas('consumers', function (Builder $query) {
                                $query->where('user_id', '=', auth()->id());
                            });
                    })
                    ->live()
                    ->preload()
                    ->searchable()
                    ->required()
                    ->afterStateUpdated(function (Set $set) {
                        $set('provider_id', null);
                    }),
                Select::make('provider_id')
                    ->translateLabel()
                    ->relationship('provider', 'name', function (Builder $query, Get $get) {
                        // Only providers of selected node
                        $nodeId = $get('node_id'); 
                        $query->where('node_id', '=', $nodeId);
                    })
                    ->preload()
                    ->searchable()
                    ->required(),
                Select::make('state')
                    ->translateLabel()
                    ->options(PurchaseState::class)
                    ->default(PurchaseState::OPEN)
                    ->preload()
                    ->searchable()
                    ->required(),
                DatePicker::make('deadline')
                    ->translateLabel()
                    ->helperText('Fecha límite para realizar pedidos.')
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->minDate(now())
                    ->required(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('node.name')
                    ->label('Nodo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('provider.name')
                    ->label('Proveedor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('deadline')
                    ->label('Cierre')
                    ->date()
                    ->sortable(),
                TextColumn::make('state')
                    ->label('Estado')
                    ->searchable()
                    ->badge()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Tables\Actions\ForceDeleteBulkAction::make(),
                    // Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => 
                // Current user as Node creator
                $query
                    ->whereHas('node', function (Builder $query) {
                        $query
                            // Current user as Node creator
                            ->where('user_id', '=', auth()->id())
                            // Or current user as Node consumer
                            ->orWhereHas('consumers', function (Builder $query) {
                                $query->where('user_id', '=', auth()->id());
                            });
                    })
            );
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->withoutGlobalScopes([
    //             // SoftDeletingScope::class,
    //         ]);
    // }
}
