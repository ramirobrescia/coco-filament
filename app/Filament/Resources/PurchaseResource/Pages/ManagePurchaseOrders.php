<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use App\Models\Product;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\App;
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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(__('Consumer'))
                    ->columns(6)
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
                Placeholder::make('provider')
                    ->translateLabel()
                    ->content($this->record->provider()->get()->first()->name),
                Repeater::make('itemsByName')
                    ->relationship()
                    ->columns(12)
                    ->columnSpanFull()
                    ->hintAction(
                        Action::make('newProduct')
                            ->translateLabel()
                            ->button()
                            ->form([
                                Grid::make('Datos')
                                    ->columns(6)
                                    ->schema([
                                        TextInput::make('name')
                                            ->translateLabel()
                                            ->required()
                                            ->columnSpanFull()
                                            ->maxLength(100),
                                        TextInput::make('weight')
                                            ->translateLabel()
                                            ->prefix('Kg')
                                            ->suffix('0,001')
                                            ->helperText('Ej: 0.025 Kg = 25 g')
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->required()
                                            ->columnSpan(3)
                                            ->minValue(0.001),
                                        TextInput::make('price')
                                            ->translateLabel()
                                            ->required()
                                            ->prefix('$')
                                            ->suffix('0,00')
                                            ->required()
                                            ->columnSpan(3)
                                            ->numeric()
                                            ->inputMode('decimal')
                                            ->minValue(0.01),
                                    ]),
                            ])
                            ->action(function (array $data) use ($form): void {
                                $purchase = $this->getOwnerRecord();

                                $data['provider_id'] = $purchase->provider_id;

                                $newProduct = Product::create($data);

                                if (is_null($newProduct)){
                                    Notification::make()
                                        ->title('No se pudo crear el producto')
                                        ->danger()
                                        ->send();
                                } else {
                                    Notification::make()
                                        ->title('El producto fue creado')
                                        ->success()
                                        ->send();
                                }
                            })
                    )
                    ->deleteAction(function (Action $action){
                        $action->after(function (Get $get, Set $set) {
                            $this->updateTotals($get, $set, '');
                        });
                    })
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
                            ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                if (!is_null($state)){
                                    $product = Product::where('id', $state)->get()->first();
                                    
                                    $set('unit_price', $product->price);
                                    $set('unit_weight', $product->weight);
                                    $set('quantity', 1);
                                    $set('price', $product->price);

                                    $this->updateTotals($get, $set);
                                }
                            }),
                        Hidden::make('unit_price'),
                        Hidden::make('unit_weight'),
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

                                    $this->updateTotals($get, $set);
                                }
                            }),
                        TextInput::make('price')
                            ->hiddenLabel()
                            ->placeholder(__('Price'))
                            ->numeric()
                            ->readOnly()
                            ->columnSpan(3),
                    ])
                    ->minItems(1),
                Grid::make()
                    ->columnSpanFull()
                    ->columns(12)
                    ->schema([
                        TextInput::make('packages')
                            ->translateLabel()
                            ->default(0)
                            ->readOnly()
                            ->columnSpan(2),
                        TextInput::make('weight')
                            ->translateLabel()
                            ->default(0.0)
                            ->readOnly()
                            ->columnSpan(4)
                            ->prefix('Kg'),
                        TextInput::make('total')
                            ->translateLabel()
                            ->default(0.0)
                            ->readOnly()
                            ->columnSpan(6)
                            ->prefix('$'),
                    ])
            ]);
    }

    private function updateTotals(Get $get, Set $set, string $basePath = '../../'){
        $items = $get($basePath . 'items');
        
        $packages = 0;
        $totalWeight = 0.0;
        $total = 0.0;

        foreach ($items as $item) {
            if(!is_null($item['unit_weight']))
                $totalWeight += $item['unit_weight'] * $item['quantity'];
            
            $packages += $item['quantity'];
            $total += $item['price'];
        }

        $set($basePath . 'packages', $packages);
        $set($basePath . 'weight', $totalWeight);
        $set($basePath . 'total', $total);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Consumer'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('packages')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('weight')
                    ->translateLabel()
                    ->suffix(' Kg')
                    ->alignEnd(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric(locale: App::currentLocale(), decimalPlaces: 2)
                    ->sortable()
                    ->alignEnd(),
            ])
            ->defaultSort('user.name')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->iconButton()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
