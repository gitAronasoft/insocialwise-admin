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
        'firstname',
        'lastname',
        'email',
        'bio',
        'company',
        'jobtitle',
        'userlocation',
        'userwebsite',
        'password',
        'role',
        'profileimage',
        'timezone',
        'otp',
        'otpgeneratedat',
        'resetpasswordtoken',
        'resetpasswordrequesttime',
        'onboardgoal',
        'onboardrole',
        'status',
        'onboard_status',
        'stripe_customer_id',
        'billing_name',
        'billing_email',
        'billing_phone',
        'billing_address_line1',
        'billing_address_line2',
        'billing_city',
        'billing_state',
        'billing_postal_code',
        'billing_country',
        'tax_id',
        'tax_id_type',
        'default_payment_method_id',
    ];

    protected $hidden = [
        'password',
        'resetpasswordtoken',
        'otp',
    ];

    protected $casts = [
        'otpgeneratedat' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function socialUsers(): HasMany
    {
        return $this->hasMany(SocialUser::class, 'user_uuid', 'uuid');
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
        return trim("{$this->firstname} {$this->lastname}");
    }

    public function getNameAttribute(): string
    {
        $name = trim("{$this->firstname} {$this->lastname}");
        return $name ?: ($this->email ?? 'Unknown');
    }
}
