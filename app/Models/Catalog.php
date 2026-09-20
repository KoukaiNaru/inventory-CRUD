<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Catalog extends Model
{
    protected $table = 'catalog';
    protected $fillable = ['name', 'type', 'power', 'price'];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'catalog_id');
    }

    public function recipes(): HasMany
    {
        return $this->hasMany(Recipe::class, 'item_id');
    }

    public function usedInRecipes(): HasMany
    {
        return $this->hasMany(Recipe::class, 'ingredient_id');
    }

    public function scopeShopItems(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereIn('type', ['weapon', 'tool'])->orderBy('price');
    }
}
