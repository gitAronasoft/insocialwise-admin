<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    protected $table = 'campaigns';

    protected $fillable = [
        'user_uuid',
        'account_id',
        'campaign_id',
        'name',
        'objective',
        'status',
        'effective_status',
        'daily_budget',
        'lifetime_budget',
        'budget_remaining',
        'start_time',
        'stop_time',
        'spend',
        'impressions',
        'reach',
        'clicks',
        'cpc',
        'cpm',
        'ctr',
    ];

    protected $casts = [
        'daily_budget' => 'decimal:2',
        'lifetime_budget' => 'decimal:2',
        'budget_remaining' => 'decimal:2',
        'spend' => 'decimal:2',
        'cpc' => 'decimal:4',
        'cpm' => 'decimal:4',
        'ctr' => 'decimal:4',
        'start_time' => 'datetime',
        'stop_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }

    public function adsAccount(): BelongsTo
    {
        return $this->belongsTo(AdsAccount::class, 'account_id', 'account_id');
    }

    public function adsets(): HasMany
    {
        return $this->hasMany(Adset::class, 'adsets_campaign_id', 'campaign_id');
    }
}
