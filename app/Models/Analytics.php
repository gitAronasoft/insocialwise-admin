<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Analytics extends Model
{
    protected $table = 'analytics';

    protected $fillable = [
        'user_uuid',
        'page_id',
        'platform',
        'date',
        'followers_count',
        'page_views',
        'page_impressions',
        'page_reach',
        'page_engaged_users',
        'page_post_engagements',
        'page_fan_adds',
        'page_fan_removes',
    ];

    protected $casts = [
        'date' => 'date',
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
}
