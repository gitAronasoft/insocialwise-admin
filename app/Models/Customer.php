<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'users';

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected $fillable = [
        'uuid',
        'firstName',
        'lastName',
        'email',
        'bio',
        'company',
        'jobTitle',
        'userLocation',
        'userWebsite',
        'password',
        'role',
        'profileImage',
        'timeZone',
        'resetPasswordToken',
        'resetPasswordRequestTime',
        'status',
    ];

    protected $hidden = [
        'password',
        'resetPasswordToken',
    ];

    protected $casts = [
        'status' => 'boolean',
        'createdat' => 'datetime',
        'updatedat' => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function socialUsers(): HasMany
    {
        return $this->hasMany(SocialUser::class, 'user_id', 'uuid');
    }

    public function socialPages(): HasMany
    {
        return $this->hasMany(SocialUserPage::class, 'user_uuid', 'uuid');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(UserPost::class, 'user_uuid', 'uuid');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'user_uuid', 'uuid');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'user_uuid', 'uuid');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }
}
