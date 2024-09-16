<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Import_equipment_requests extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'code',
        'supplier_code',
        'note',
        'status',
        'request_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
