<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostComment extends Model
{
    protected $table = 'post_comments';

    protected $fillable = [
        'post_id',
        'comment_id',
        'parent_id',
        'from_id',
        'from_name',
        'message',
        'sentiment',
        'reply_count',
        'like_count',
        'created_time',
    ];

    protected $casts = [
        'created_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function post(): BelongsTo
    {
        return $this->belongsTo(UserPost::class, 'post_id', 'platform_post_id');
    }
}
