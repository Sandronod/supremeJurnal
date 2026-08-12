<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name_ka',
        'site_name_en',
        'issn',
        'copyright_text_ka',
        'copyright_text_en',
        'phone',
        'email',
        'address_ka',
        'address_en',
        'map_embed_url',
        'facebook_url',
    ];

    public static function current(): self
    {
        return static::query()->firstOrFail();
    }

    public function getSiteNameAttribute(): string
    {
        return app()->getLocale() === 'ka' ? $this->site_name_ka : $this->site_name_en;
    }

    public function getCopyrightTextAttribute(): ?string
    {
        return app()->getLocale() === 'ka' ? $this->copyright_text_ka : $this->copyright_text_en;
    }

    public function getAddressAttribute(): ?string
    {
        return app()->getLocale() === 'ka' ? $this->address_ka : $this->address_en;
    }
}
