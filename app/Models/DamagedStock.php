<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class DamagedStock extends Model
{
    protected $fillable = [
        'inventory_id',
        'available_stock',
        'damaged_qty',
        'reason',
        'notes',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }
}
