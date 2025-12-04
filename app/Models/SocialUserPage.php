<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialUserPage extends Model
{
    protected $table = 'social_page';

    protected $fillable = [
        'user_uuid',
        'social_userid',
        'pageId',
        'name',
        'category',
        'picture',
        'token',
        'platform',
        'status',
    ];

    protected $hidden = [
        'token',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }

    public function socialUser(): BelongsTo
    {
        return $this->belongsTo(SocialUser::class, 'social_userid', 'social_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(UserPost::class, 'page_id', 'pageId');
    }

    public function analytics(): HasMany
    {
        return $this->hasMany(Analytics::class, 'page_id', 'pageId');
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(InboxConversation::class, 'page_id', 'pageId');
    }
}
