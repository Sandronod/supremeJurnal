<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_id',
        'title_ka',
        'title_en',
        'authors',
        'abstract_ka',
        'abstract_en',
        'pdf_path',
        'cover_image_path',
        'slug',
        'sort_order',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }

    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'ka' ? $this->title_ka : $this->title_en;
    }

    public function getAbstractAttribute(): ?string
    {
        return app()->getLocale() === 'ka' ? $this->abstract_ka : $this->abstract_en;
    }
}
