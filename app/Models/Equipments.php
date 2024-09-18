<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipments extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'barcode',
        'description',
        'price',
        'country',
        'equipment_type_code',
        'supplier_code',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
