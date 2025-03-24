<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'weight', 'price',
    ];

    /**
     * Get the items of the order.
     */
    public function provider(): HasOne
    {
        return $this->hasOne(Provider::class);
    }
}
