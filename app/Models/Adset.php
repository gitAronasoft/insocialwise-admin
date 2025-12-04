<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Adset extends Model
{
    protected $table = 'adsets';

    protected $fillable = [
        'user_uuid',
        'campaign_id',
        'adset_id',
        'name',
        'status',
        'effective_status',
        'daily_budget',
        'lifetime_budget',
        'budget_remaining',
        'optimization_goal',
        'billing_event',
        'bid_amount',
        'start_time',
        'end_time',
        'targeting',
    ];

    protected $casts = [
        'daily_budget' => 'decimal:2',
        'lifetime_budget' => 'decimal:2',
        'budget_remaining' => 'decimal:2',
        'bid_amount' => 'decimal:2',
        'targeting' => 'array',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'adsets_campaign_id', 'campaign_id');
    }

    public function ads(): HasMany
    {
        return $this->hasMany(AdsetAd::class, 'adsets_id', 'adsets_id');
    }
}
