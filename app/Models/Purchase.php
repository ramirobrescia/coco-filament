<?php

namespace App\Models;

use App\PurchaseState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * A Purchase is a set of orders to one provider from a Node 
 */
class Purchase extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'node_id', 'provider_id', 'state', 'deadline',
    ];

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
    public function node(): BelongsTo
    {
        return $this->belongsTo(Node::class);
    }

    /**
     * Get the provider of the purchase.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * Get the orders of the purchase.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the total amount of the purchase.
     */
    public function total(): float
    {
        return $this->orders()->sum('total');
    }

    /**
     * Get the total weight of the purchase.
     */
    public function weight(): float
    {
        return $this->orders()->sum('weight');
    }

    /**
     * Get the total packages of the purchase.
     */
    public function packages(): float
    {
        return $this->orders()->sum('packages');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'state' => PurchaseState::class,
        ];
    }
}
