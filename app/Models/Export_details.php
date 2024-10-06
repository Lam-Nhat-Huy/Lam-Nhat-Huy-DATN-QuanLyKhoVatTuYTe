<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Export_details extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'id',
        'export_code',
        'equipment_code',
        'batch_number',
        'quantity',
        'required_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
