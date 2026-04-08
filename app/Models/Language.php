<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'native_name', 'flag_emoji', 'flag_code', 'description', 'price_monthly', 'is_active', 'sort_order'])]
class Language extends Model
{
    public function levels(): HasMany
    {
        return $this->hasMany(Level::class)->orderBy('sort_order');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
