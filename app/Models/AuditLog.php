<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'admin_name',
        'action',
        'entity_type',
        'entity_id',
        'before_data',
        'after_data',
        'changed_at',
    ];

    protected $casts = [
        'before_data' => 'array',
        'after_data' => 'array',
        'changed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
