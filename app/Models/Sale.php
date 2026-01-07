<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Sale extends Model
{
    protected $fillable = [
        'inventory_id',
        'channel_id',
        'customer',
        'date',
        'qty',
        'total_price',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }
}
