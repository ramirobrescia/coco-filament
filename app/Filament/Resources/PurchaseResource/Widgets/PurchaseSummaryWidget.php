<?php

namespace App\Filament\Resources\PurchaseResource\Widgets;

use App\Models\OrderItem;
use App\Models\Purchase;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PurchaseSummaryWidget extends BaseWidget
{

    public ?Purchase $record = null;

    protected int | string | array $columnSpan = 'full';

    public function mount($record)
    {
        $this->record = $record;
    }

    public function getTableRecordKey($record): string
    {
        return (string) $record->product_id;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Estado actual de la compra')
            ->query(fn () =>
                OrderItem::query()
                    ->whereHas('order', function ($q) {
                        $q->where('purchase_id', $this->record->id);
                    })
                    ->selectRaw('product_id, sum(quantity) as total_quantity, unit_price, sum(price) as total_price')
                    ->with('product')
                    ->groupBy('product_id')
            )
            ->columns([
                Tables\Columns\TextColumn::make('total_quantity')
                    ->label(__('Quantity'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label(__('Product'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit_price')
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label(__('Total'))
                    ->sortable(),
            ])
            ->defaultSort('product.name');
    }
    
}
