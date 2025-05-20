<?php

namespace App\Filament\Actions;

use App\InvitationState;
use App\Mail\NodeInvitationEmail;
use App\Models\Invitation;
use App\Models\Purchase;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UpdatePurchaseOrdersItemPrices extends Action
{

    public static function getDefaultName(): ?string
    {
        return 'updatePurchaseOrdersItemPrices';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('Update Prices'));

        $this->requiresConfirmation();

        $this->action(function () {
            
            // TODO find a better way to get the owner record
            $purchase = $this->getLivewire()->getOwnerRecord();

            foreach($purchase->orders()->get() as $order){

                $order->total = 0;

                foreach ($order->items()->get() as $item){
                    $product = $item->product()->first();

                    $item->unit_price = $product->price;
                    $item->price = $item->unit_price * $item->quantity;

                    $order->total += $item->price;

                    $item->save();
                }
                
                $order->save();
            }

            $this->successNotification(
                Notification::make()
                    ->success()
                    ->title('Los precios fueron actualizados con exito')
            );

            $this->success();
        });
    }
}
