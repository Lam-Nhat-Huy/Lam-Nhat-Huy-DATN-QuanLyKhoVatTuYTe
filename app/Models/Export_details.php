<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Export_details extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'export_code',
        'equipment_code',
        'quantity',
        'batch_number',
    ];

    public function export()
    {
        return $this->belongsTo(Exports::class, 'export_code', 'code');
    }

    public function equipments()
    {
        return $this->belongsTo(Equipments::class, 'equipment_code', 'code');
    }
}
