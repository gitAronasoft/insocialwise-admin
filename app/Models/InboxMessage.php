<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InboxMessage extends Model
{
    protected $table = 'inbox_messages';

    protected $fillable = [
        'conversation_id',
        'platform_message_id',
        'sender_type',
        'message_text',
        'message_type',
        'attachment_url',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(InboxConversation::class, 'conversation_id', 'conversation_id');
    }

    public function isFromPage(): bool
    {
        return $this->sender_type === 'page';
    }

    public function isFromUser(): bool
    {
        return $this->sender_type === 'user';
    }
}
