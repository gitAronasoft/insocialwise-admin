<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Demographics extends Model
{
    protected $table = 'demographics';

    protected $fillable = [
        'user_uuid',
        'page_id',
        'platform',
        'date',
        'age_gender',
        'country',
        'city',
        'locale',
    ];

    protected $casts = [
        'date' => 'date',
        'age_gender' => 'array',
        'country' => 'array',
        'city' => 'array',
        'locale' => 'array',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(SocialUserPage::class, 'page_id', 'pageId');
    }
}
