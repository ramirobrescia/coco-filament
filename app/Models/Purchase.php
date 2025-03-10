<?php

namespace App\Models;

use App\PurchaseState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * A Purchase is a set of orders to one provider from a Node 
 */
class Purchase extends Model
{
    /**
     * The model's default values for attributes.
     * @var array
     */
    protected $attributes = [
        'state' => PurchaseState::OPEN,
    ];

    /**
     * Get the Node where the Purchase belongs.
     */
    public function node(): HasOne
    {
        return $this->hasOne(Node::class);
    }

    /**
     * Get the provider of the purchase.
     */
    public function provider(): HasOne
    {
        return $this->hasOne(Provider::class);
    }

    /**
     * Get the orders of the purchase.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
