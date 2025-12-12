<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialUser extends Model
{
    protected $table = 'social_users';

    protected $fillable = [
        'user_uuid',
        'social_id',
        'platform',
        'name',
        'email',
        'profile_pic',
        'token',
        'token_expires_at',
        'status',
    ];

    protected $hidden = [
        'token',
    ];

    protected $casts = [
        'token_expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }

    public function pages(): HasMany
    {
        return $this->hasMany(SocialUserPage::class, 'social_userid', 'social_id');
    }
}
