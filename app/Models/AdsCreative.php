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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function ad(): BelongsTo
    {
        return $this->belongsTo(AdsetAd::class, 'creative_id', 'creative_id');
    }
}
