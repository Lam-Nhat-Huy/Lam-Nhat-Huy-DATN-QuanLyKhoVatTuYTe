<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Export_equipment_requests extends Model
{
    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'code',
        'department_code',
        'reason_export',
        'note',
        'status',
        'request_date',
        'required_date',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    public function users()
    {
        return $this->belongsTo(Users::class, 'created_by', 'code');
    }

    public function departments()
    {
        return $this->belongsTo(Departments::class, 'department_code', 'code');
    }

    public function export_equipment_request_details()
    {
        return $this->hasMany(Export_equipment_request_details::class, 'export_request_code', 'code');
    }
}
