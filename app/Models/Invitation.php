<?php

namespace App\Models;

use App\InvitationState;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * The invitation to join to a consumption node.
 * 
 * @property integer $id
 * @property integer $state
 * @property string $consumers
 * @property Node nodes()
 * @property User user()
 */
class Invitation extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'consumers',
        'node_id',
        'user_id',
    ];

    /**
     * Get the creator of the invite.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Node where the consumers are invited.
     */
    public function node(): BelongsTo
    {
        return $this->belongsTo(Node::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'consumers' => 'array',
        ];
    }

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
     protected $attributes = [
        'state' => InvitationState::CREATED,
    ];

}
