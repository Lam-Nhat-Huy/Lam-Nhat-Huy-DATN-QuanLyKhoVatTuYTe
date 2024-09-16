<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Export_equipment_requests extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'code',
        'department_code',
        'note',
        'status',
        'request_date',
        'reason',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
