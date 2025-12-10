<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialMediaScore extends Model
{
    protected $table = 'social_media_score';

    protected $fillable = [
        'user_uuid',
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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }
}
