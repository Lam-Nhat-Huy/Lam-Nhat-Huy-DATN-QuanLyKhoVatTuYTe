<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suppliers extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'contact_name',
        'tax_code',
        'email',
        'phone',
        'address',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
