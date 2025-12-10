<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdsAccount extends Model
{
    protected $table = 'ads_accounts';

    protected $fillable = [
        'user_uuid',
        'account_id',
        'name',
        'currency',
        'timezone_name',
        'account_status',
        'disable_reason',
        'amount_spent',
        'balance',
    ];

    protected $casts = [
        'amount_spent' => 'decimal:2',
        'balance' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class, 'account_id', 'account_id');
    }
}
