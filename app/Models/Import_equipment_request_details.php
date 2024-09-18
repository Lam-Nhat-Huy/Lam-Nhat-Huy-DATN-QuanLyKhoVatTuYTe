<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Import_equipment_request_details extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'code',
        'import_request_code',
        'equipment_code',
        'quantity',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
