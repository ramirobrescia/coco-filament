<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    /**
     * Get the items of the order.
     */
    public function provider(): HasOne
    {
        return $this->hasOne(Provider::class);
    }
}
