<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AdsetAd extends Model
{
    protected $table = 'adsets_ads';

    protected $fillable = [
        'user_uuid',
        'adset_id',
        'ad_id',
        'name',
        'status',
        'effective_status',
        'creative_id',
        'impressions',
        'reach',
        'clicks',
        'spend',
        'cpc',
        'cpm',
        'ctr',
    ];

    protected $casts = [
        'spend' => 'decimal:2',
        'cpc' => 'decimal:4',
        'cpm' => 'decimal:4',
        'ctr' => 'decimal:4',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function adset(): BelongsTo
    {
        return $this->belongsTo(Adset::class, 'adsets_id', 'adsets_id');
    }

    public function creative(): HasOne
    {
        return $this->hasOne(AdsCreative::class, 'creative_id', 'creative_id');
    }
}
