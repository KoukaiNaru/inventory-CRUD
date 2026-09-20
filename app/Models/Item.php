<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static Builder|Item query()
 * @method static \Illuminate\Database\Eloquent\Model|Item findOrFail($id)
 * @mixin Builder
 */
class Item extends Model
{
    protected $fillable = ['user_id', 'catalog_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function catalog(): BelongsTo
    {
        return $this->belongsTo(Catalog::class, 'catalog_id');
    }

    public function getTitleAttribute(): string
    {
        return $this->catalog?->name ?? 'Без названия';
    }

    public function getPowerAttribute(): int
    {
        return $this->catalog?->power ?? 0;
    }

    public function getDescriptionAttribute(): ?string
    {
        if (!$this->catalog) {
            return null;
        }
        return match ($this->catalog->type) {
            'weapon' => 'Боевое оружие',
            'tool' => 'Инструмент для добычи',
            default => 'Ресурс для крафта',
        };
    }

    public function getTypeAttribute(): string
    {
        return $this->catalog?->type ?? 'resource';
    }

    public function getPriceAttribute(): int
    {
        return $this->catalog?->price ?? 10;
    }

    public function getSellPriceAttribute(): int
    {
        $base = $this->catalog?->price ?? 10;
        return max(1, (int) round($base * 0.6));
    }
}
