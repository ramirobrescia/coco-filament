<?php

namespace App;

use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;

enum PurchaseState: string implements HasLabel, HasDescription
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case ORDERED = 'ordered';
    case PREPARING = 'preparing';
    case DELIVERED = 'delivered';
    case RECIVED = 'recived';

    public function getLabel(): ?string
    {
        return __('purchase.state.' . $this->name . '.label');
    }

    public function getDescription(): ?string
    {
        return __('purchase.state.' . $this->name . '.description');
    }
}
