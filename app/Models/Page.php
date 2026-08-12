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
}
