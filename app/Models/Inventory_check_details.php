<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory_check_details extends Model
{
    use HasFactory;

    protected $fillable = [
        'int',
        'inventory_check_code',
        'equipment_code',
        'current_quantity',
        'actual_quantity',
        'unequal',
        'batch_number',
        'equipment_note',
        'check_round',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipments::class, 'equipment_code', 'code');
    }
}