<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Inventory extends Model
{
    protected $fillable = [
        'category_id',
        'product',
        'stock',
        'price',
        'selling_price',
    ];

    protected $appends = ['status'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getStatusAttribute(): string
    {
        $stock = (int) $this->stock;

        $min = (int) ($this->category?->min_stock ?? 0);

        if ($stock <= 0) {
            return 'out_of_stock';
        }

        if ($stock <= ($min + 2)) return 'low';

        return 'good';
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
