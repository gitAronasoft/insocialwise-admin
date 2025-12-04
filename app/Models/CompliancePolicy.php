<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompliancePolicy extends Model
{
    protected $table = 'compliance_policies';

    protected $fillable = [
        'policy_type',
        'content',
        'version',
        'effective_date',
        'active',
        'updated_by',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function getActivePolicy(string $type): ?self
    {
        return static::where('policy_type', $type)
            ->where('active', true)
            ->first();
    }

    public function getPolicyTypeLabelAttribute(): string
    {
        return match ($this->policy_type) {
            'privacy_policy' => 'Privacy Policy',
            'terms_of_service' => 'Terms of Service',
            'cookie_policy' => 'Cookie Policy',
            'data_retention' => 'Data Retention Policy',
            'gdpr' => 'GDPR Compliance',
            default => ucfirst(str_replace('_', ' ', $this->policy_type)),
        };
    }

    public function updatedByAdmin()
    {
        return $this->belongsTo(AdminUser::class, 'updated_by');
    }
}
