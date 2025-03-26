<?php

namespace App;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;

enum PurchaseState: string implements HasLabel, HasDescription, HasColor
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

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::OPEN => 'sky',
            self::CLOSED => 'danger',
            self::ORDERED => 'yellow',
            self::PREPARING => 'amber',
            self::DELIVERED => 'orange',
            self::RECIVED => 'lime',
        };
    }
}
