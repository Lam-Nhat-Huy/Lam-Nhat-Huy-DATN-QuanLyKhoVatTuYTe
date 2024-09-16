<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notifications extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'code',
        'user_code',
        'notification_type',
        'content',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
