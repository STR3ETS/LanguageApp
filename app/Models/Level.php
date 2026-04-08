<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['language_id', 'number', 'name', 'description', 'cefr', 'xp_required', 'sort_order'])]
class Level extends Model
{
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }
}
