<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KnowledgeBase extends Model
{
    protected $table = 'knowledge_base';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'status',
        'views_count',
        'helpful_count',
        'not_helpful_count',
        'author_id',
    ];

    protected $casts = [
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function meta(): HasMany
    {
        return $this->hasMany(KnowledgebaseMeta::class, 'knowledgebase_id', 'id');
    }

    public function getHelpfulRateAttribute(): float
    {
        $total = $this->helpful_count + $this->not_helpful_count;
        if ($total > 0) {
            return round(($this->helpful_count / $total) * 100, 2);
        }
        return 0;
    }
}
