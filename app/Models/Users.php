<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'code',
        'first_name',
        'last_name',
        'avatar',
        'email',
        'phone',
        'password',
        'birth_day',
        'gender',
        'address',
        'position',
        'isAdmin',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
