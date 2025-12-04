<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataRequest extends Model
{
    protected $table = 'data_requests';

    protected $fillable = [
        'user_uuid',
        'user_email',
        'request_type',
        'status',
        'notes',
        'completed_at',
        'processed_by',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function getPendingCount(): int
    {
        return static::where('status', 'pending')->count();
    }

    public function getRequestTypeLabelAttribute(): string
    {
        return match ($this->request_type) {
            'export' => 'Data Export',
            'delete' => 'Data Deletion (Right to be Forgotten)',
            'access' => 'Data Access',
            'rectification' => 'Data Rectification',
            default => ucfirst($this->request_type),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'processing' => 'blue',
            'completed' => 'green',
            'rejected' => 'red',
            default => 'gray',
        };
    }

    public function processedByAdmin()
    {
        return $this->belongsTo(AdminUser::class, 'processed_by');
    }

    public function markAsProcessing(?int $adminId = null): void
    {
        $this->update([
            'status' => 'processing',
            'processed_by' => $adminId,
        ]);
    }

    public function markAsCompleted(?int $adminId = null): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'processed_by' => $adminId,
        ]);
    }

    public function markAsRejected(string $reason, ?int $adminId = null): void
    {
        $this->update([
            'status' => 'rejected',
            'notes' => $reason,
            'completed_at' => now(),
            'processed_by' => $adminId,
        ]);
    }
}
