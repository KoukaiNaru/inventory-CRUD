<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    public $timestamps = false;

    protected $fillable = ['item_id', 'ingredient_id', 'quantity'];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Catalog::class, 'item_id');
    }

    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(Catalog::class, 'ingredient_id');
    }
}
