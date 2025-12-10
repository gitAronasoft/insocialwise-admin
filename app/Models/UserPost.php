<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserPost extends Model
{
    protected $table = 'posts';

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_SCHEDULED = 2;
    const STATUS_FAILED = 3;

    protected $fillable = [
        'user_uuid',
        'social_user_id',
        'page_id',
        'content',
        'schedule_time',
        'post_media',
        'platform_post_id',
        'post_platform',
        'source',
        'form_id',
        'likes',
        'comments',
        'shares',
        'engagements',
        'impressions',
        'unique_impressions',
        'week_date',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(SocialUserPage::class, 'page_id', 'pageId');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class, 'post_id', 'platform_post_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ((int)$this->status) {
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_SCHEDULED => 'Scheduled',
            self::STATUS_FAILED => 'Failed',
            default => 'Unknown',
        };
    }

    public function getEngagementRateAttribute(): float
    {
        $total = $this->likes + $this->comments + $this->shares;
        if ($this->unique_impressions > 0) {
            return round(($total / $this->unique_impressions) * 100, 2);
        }
        return 0;
    }
}
