<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'user_uuid',
        'module_name',
        'module_status',
    ];

    protected $casts = [
        'module_status' => 'boolean',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_uuid', 'uuid');
    }
}
