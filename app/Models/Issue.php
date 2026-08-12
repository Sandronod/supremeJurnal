<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'number',
        'pdf_path',
        'published_at',
        'is_current',
    ];

    protected $casts = [
        'published_at' => 'date',
        'is_current' => 'boolean',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class)->orderBy('sort_order');
    }

    public function getLabelAttribute(): string
    {
        return "{$this->year}, #{$this->number}";
    }
}
