<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'user_id';

    public const UPDATED_AT = null;

    protected $fillable = [
        'username',
        'email',
        'age',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
        ];
    }
}
