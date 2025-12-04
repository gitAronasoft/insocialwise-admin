<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdsCreative extends Model
{
    protected $table = 'ads_creative';

    protected $fillable = [
        'user_uuid',
        'creative_id',
        'name',
        'title',
        'body',
        'image_url',
        'video_url',
        'link_url',
        'call_to_action',
        'object_type',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function ad(): BelongsTo
    {
        return $this->belongsTo(AdsetAd::class, 'creative_id', 'creative_id');
    }
}
