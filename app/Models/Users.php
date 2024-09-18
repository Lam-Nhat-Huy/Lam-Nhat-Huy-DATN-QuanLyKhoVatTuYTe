<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

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

    public function receipts()
    {
        return $this->hasMany(Receipts::class, 'created_by', 'code');
    }
}
