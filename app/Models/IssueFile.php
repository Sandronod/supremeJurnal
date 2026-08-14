<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IssueFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_id',
        'label_ka',
        'label_en',
        'file_path',
        'sort_order',
    ];

    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }

    public function getLabelAttribute(): string
    {
        return app()->getLocale() === 'ka' ? $this->label_ka : $this->label_en;
    }
}
