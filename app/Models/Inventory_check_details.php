<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory_check_details extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'code',
        'inventory_check_code',
        'equipment_code',
        'current_quantity',
        'actual_quantity',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
