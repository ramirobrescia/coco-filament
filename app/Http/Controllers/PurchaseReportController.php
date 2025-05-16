<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Purchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PurchaseReportController extends Controller
{

    /**
     * Generates .
     */
    public function show(string $id)
    {
        $purchase = Purchase::with(['provider', 'orders', 'node'])
            ->where('id', $id)
            ->firstOrFail();

        // Product summary from orders
        $purchaseItems = $purchase->orders()->get()
            ->map(function (Order $order){
                return $order->items()->with('product')->get();
            })
            ->flatten()
            ->groupBy('product_id')
            ->map(function (Collection $productItems){
                $firstItem = $productItems->first();
                $product = [
                    'name' => $firstItem->product()->get()->first()->name,
                    'price' => $firstItem->unit_price,
                    'quantity' => 0.0,
                    'total' => 0.0,
                ];
                
                foreach ($productItems as $item) {
                    $product['quantity'] += $item->quantity;
                    $product['total'] += $item->price;
                }

                return $product;
            })
            ->sortBy('name');

        $data = [
            'purchase' => $purchase,
            'contact' => [
                'name' => 'Juan Perez',
                'phone' => '11 36258524'
            ],
            'items' => $purchaseItems
        ];

        // <provider> purchase <node> <date>
        $filename = Str::of('? ? ? ?')
            ->replaceArray('?', [$purchase->provider->name, __('Purchase'), $purchase->node->name, date('Y-m-d')])
            ->slug();
        
        $pdf = Pdf::loadView('reports.purchase.purchase', $data);
        
        return $pdf->download($filename);
    }

    /**
     * Generates a PDF with all orders of a Purchase.
     */
    public function orders(string $id)
    {
        $purchase = Purchase::with(['provider', 'orders',  'node'])
            ->where('id', $id)
            ->firstOrFail();

        // dd($purchase->orders->first()->items->first()->product);

        $data = [
            'purchase' => $purchase,
            'contact' => [
                'name' => 'Juan Perez',
                'phone' => '11 36258524'
            ],
        ];

        // <provider> purchase <node> <date>
        $filename = Str::of('? ? ? ?')
            ->replaceArray('?', [$purchase->provider->name, __('orders'), $purchase->node->name, date('Y-m-d')])
            ->slug();
        
        $pdf = Pdf::loadView('reports.purchase.orders', $data);
        
        return $pdf->download($filename);
    }

}
