<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'label_ka',
        'label_en',
        'route_name',
        'route_param',
        'custom_url',
        'sort_order',
    ];

    /**
     * Known internal destinations an admin can point a menu item at,
     * keyed by a stable identifier used only in the admin form.
     */
    public static function internalTargets(): array
    {
        return [
            'home' => ['route' => 'home', 'param' => null, 'label_ka' => 'მთავარი', 'label_en' => 'Home'],
            'about.aims-scope' => ['route' => 'about.show', 'param' => 'aims-scope', 'label_ka' => 'მიზნები და ამოცანები', 'label_en' => 'Aims & Scope'],
            'about.review-ethics' => ['route' => 'about.show', 'param' => 'review-ethics', 'label_ka' => 'რეცენზირება და ეთიკა', 'label_en' => 'Review & Ethics'],
            'editorial-board' => ['route' => 'editorial-board', 'param' => null, 'label_ka' => 'სარედაქციო კოლეგია', 'label_en' => 'Editorial Board'],
            'issues.current' => ['route' => 'issues.current', 'param' => null, 'label_ka' => 'მიმდინარე ნომერი', 'label_en' => 'Current Issue'],
            'issues.archive' => ['route' => 'issues.archive', 'param' => null, 'label_ka' => 'არქივი', 'label_en' => 'Archive'],
            'for-authors' => ['route' => 'for-authors', 'param' => null, 'label_ka' => 'ავტორთა საყურადღებოდ', 'label_en' => 'For Authors'],
            'contact' => ['route' => 'contact', 'param' => null, 'label_ka' => 'კონტაქტი', 'label_en' => 'Contact'],
            'search' => ['route' => 'search', 'param' => null, 'label_ka' => 'ძიება', 'label_en' => 'Search'],
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function getLabelAttribute(): string
    {
        return app()->getLocale() === 'ka' ? $this->label_ka : $this->label_en;
    }

    public function getResolvedUrlAttribute(): string
    {
        if ($this->route_name) {
            try {
                return $this->route_param
                    ? route($this->route_name, $this->route_param)
                    : route($this->route_name);
            } catch (\Exception $e) {
                return '#';
            }
        }

        return $this->custom_url ?: '#';
    }
}
