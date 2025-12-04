<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminFeatureFlag extends Model
{
    protected $table = 'admin_feature_flags';

    protected $fillable = [
        'feature_key',
        'feature_name',
        'description',
        'category',
        'enabled',
        'force_enabled',
        'updated_by',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'force_enabled' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function isEnabled(string $featureKey): bool
    {
        $flag = static::where('feature_key', $featureKey)->first();
        return $flag ? $flag->enabled : false;
    }

    public static function toggle(string $featureKey, bool $enabled, ?int $updatedBy = null): bool
    {
        $flag = static::where('feature_key', $featureKey)->first();
        if (!$flag || $flag->force_enabled) {
            return false;
        }
        
        $flag->update([
            'enabled' => $enabled,
            'updated_by' => $updatedBy,
        ]);
        
        return true;
    }

    public static function canToggle(string $featureKey): bool
    {
        $flag = static::where('feature_key', $featureKey)->first();
        return $flag && !$flag->force_enabled;
    }

    public static function getAllByCategory(): array
    {
        return static::all()->groupBy('category')->toArray();
    }

    public function updatedByAdmin()
    {
        return $this->belongsTo(AdminUser::class, 'updated_by');
    }
}
