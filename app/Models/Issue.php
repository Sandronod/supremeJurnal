<?php

namespace App\Models;

use App\Support\Html;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'number',
        'title_ka',
        'title_en',
        'cover_image_path',
        'description_ka',
        'description_en',
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

    public function files(): HasMany
    {
        return $this->hasMany(IssueFile::class)->orderBy('sort_order');
    }

    public function getLabelAttribute(): string
    {
        return "{$this->year}, #{$this->number}";
    }

    public function getDescriptionAttribute(): ?string
    {
        return Html::externalLinksBlank(app()->getLocale() === 'ka' ? $this->description_ka : $this->description_en);
    }

    /**
     * The stored per-issue title, falling back to a generated
     * "Journal '<site name>' <year>" when no title was set.
     */
    public function getTitleAttribute(): string
    {
        $stored = app()->getLocale() === 'ka' ? $this->title_ka : $this->title_en;

        if ($stored) {
            return $stored;
        }

        $siteName = Setting::query()->first()?->site_name ?? config('app.name');

        return app()->getLocale() === 'ka'
            ? "ჟურნალი \"{$siteName}\" {$this->year}"
            : "Journal \"{$siteName}\" {$this->year}";
    }
}
