<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InboxConversation extends Model
{
    protected $table = 'inbox_conversations';

    protected $fillable = [
        'user_uuid',
        'page_id',
        'conversation_id',
        'participant_id',
        'participant_name',
        'participant_picture',
        'snippet',
        'message_count',
        'unread_count',
        'can_reply',
    ];

    protected $casts = [
        'can_reply' => 'boolean',
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

    public function messages(): HasMany
    {
        return $this->hasMany(InboxMessage::class, 'conversation_id', 'conversation_id');
    }
}
