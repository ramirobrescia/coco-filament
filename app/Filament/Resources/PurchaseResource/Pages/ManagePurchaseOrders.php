<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use App\Models\Product;
use App\Models\User;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\HtmlString;

class ManagePurchaseOrders extends ManageRelatedRecords
{
    protected static string $resource = PurchaseResource::class;

    protected static string $relationship = 'orders';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('Order');
    }

    public static function getNavigationLabel(): string
    {
        return __('Orders');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Order');
    }
    
    public function getHeading(): string | Htmlable
    {
        return __('Orders');
    }
    
    public function getSubHeading(): string | Htmlable
    {
        $node = $this->record->node()->first();
        $provider = $this->record->provider()->first();

        $subHeading = sprintf('Listado de pedidos de la compra del nodo <strong>%s</strong> a <strong>%s</strong>', 
            $node->name,
            $provider->name);

        return new HtmlString($subHeading);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordCreation(array $data): Model
    {
        $record = new ($this->getModel())($data);

        dd($record);

        return $record;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->translateLabel()
                    ->relationship('user', 'name', function (Builder $query){
                        $node = $this->record->node()->get()->first();
                        
                        $query->join('node_user', function (JoinClause $join) use ($node) {
                            $join->on('users.id', '=', 'node_user.user_id')
                                ->where('node_user.node_id', '=', $node->id);
                        });
                    })
                    ->default(auth()->id())
                    ->preload()
                    ->searchable(),
                Repeater::make('item')
                    ->relationship('items')
                    ->columns(12)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('product_id')
                            ->hiddenLabel()
                            ->placeholder(__('Product'))
                            ->relationship('product', 'name', function (Builder $query){
                                $providerId = $this->record->provider()->get()->first()->id;
                                $query->where('provider_id', '=', $providerId);
                            })
                            ->live()
                            ->searchable()
                            ->columnSpan(6)
                            ->afterStateUpdated(function ($state, Set $set) {
                                if (!is_null($state)){
                                    $product = Product::where('id', $state)->get()->first();
                                    
                                    $set('unit_price', $product->price);
                                    $set('quantity', 1);
                                    $set('price', $product->price);
                                }
                            }),
                        TextInput::make('unit_price')
                            ->hidden()
                            ->default(0),
                        TextInput::make('quantity')
                            ->hiddenLabel()
                            ->placeholder(__('Quantity'))
                            ->numeric()
                            ->required()
                            ->columnSpan(3)
                            ->live()
                            ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                if (!is_null($state)){
                                    $set('price', $get('unit_price') * $state);
                                }
                            }),
                        TextInput::make('price')
                            ->hiddenLabel()
                            ->placeholder(__('Price'))
                            ->numeric()
                            ->required()
                            ->columnSpan(3),
                    ])
                    ->minItems(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
