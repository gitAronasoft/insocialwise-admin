<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    protected $table = 'activity';

    protected $fillable = [
        'user_uuid',
        'account_social_userid',
        'account_platform',
        'activity_type',
        'activity_subType',
        'action',
        'source_type',
        'post_form_id',
        'reference_pageID',
        'nextAPI_call_dateTime',
    ];

    protected $casts = [
        'reference_pageID' => 'array',
        'nextAPI_call_dateTime' => 'datetime',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }

    public function getDescriptionAttribute(): string
    {
        return "{$this->activity_type} - {$this->activity_subType}: {$this->action}";
    }
}
