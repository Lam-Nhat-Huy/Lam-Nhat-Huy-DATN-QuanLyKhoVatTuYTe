<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Export_equipment_request_details extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'id',
        'equipment_code',
        'export_request_code',
        'quantity',
        'status',
    ];

    public function equipments()
    {
        return $this->belongsTo(Equipments::class, 'equipment_code', 'code');
    }

    public function exportEquipmentRequests()
    {
        return $this->belongsTo(Export_equipment_requests::class, 'export_request_code', 'code');
    }
}
