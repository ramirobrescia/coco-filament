<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A Node is a group of consumers (User), that makes purchases to many providers. 
 */
class Node extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get the user that create the node.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the group of consumers of this node.
     */
    public function consumers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'node_user')
            ->withTimestamps();
    }

    /**
     * Get the providers of the node.
     */
    public function providers(): HasMany
    {
        return $this->hasMany(Provider::class);
    }

    /**
     * Get the purchases of the node.
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
