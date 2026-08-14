<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title_ka',
        'title_en',
        'body_ka',
        'body_en',
    ];

    public function getTitleAttribute(): string
    {
        return app()->getLocale() === 'ka' ? $this->title_ka : $this->title_en;
    }

    public function getBodyAttribute(): ?string
    {
        return app()->getLocale() === 'ka' ? $this->body_ka : $this->body_en;
    }

    /**
     * Slugs seeded by PageSeeder that have their own dedicated public route
     * (home, about.show, editorial-board, for-authors) — these can be
     * edited but not deleted, since removing them would break navigation.
     * Any other page is admin-created and freely deletable.
     */
    public static function fixedSlugs(): array
    {
        return ['about', 'aims-scope', 'review-ethics', 'editorial-board', 'for-authors'];
    }

    public function isFixed(): bool
    {
        return in_array($this->slug, self::fixedSlugs(), true);
    }
}
