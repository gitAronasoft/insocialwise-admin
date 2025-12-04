<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialUser extends Model
{
    protected $table = 'social_users';

    protected $fillable = [
        'user_id',
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
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_id', 'uuid');
    }

    public function pages(): HasMany
    {
        return $this->hasMany(SocialUserPage::class, 'social_userid', 'social_id');
    }
}
