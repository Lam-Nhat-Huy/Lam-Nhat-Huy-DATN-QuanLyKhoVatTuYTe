<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departments extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'location',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
