<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialMediaPageScore extends Model
{
    protected $table = 'social_media_page_score';

    protected $fillable = [
        'user_uuid',
        'page_id',
        'platform',
        'overall_score',
        'content_score',
        'engagement_score',
        'growth_score',
        'consistency_score',
        'calculated_at',
    ];

    protected $casts = [
        'overall_score' => 'decimal:2',
        'content_score' => 'decimal:2',
        'engagement_score' => 'decimal:2',
        'growth_score' => 'decimal:2',
        'consistency_score' => 'decimal:2',
        'calculated_at' => 'datetime',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(SocialUserPage::class, 'page_id', 'pageId');
    }
}
