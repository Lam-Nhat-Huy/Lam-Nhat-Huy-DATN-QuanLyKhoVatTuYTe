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
        'user_code',
        'department_code',
        'reason_export',
        'note',
        'status',
        'request_date',
        'required_date',
        'reason_refuse',
        'allow_to_edit',
        'created_at',
        'user_code',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
        'browse_by',
    ];

    public function users()
    {
        return $this->belongsTo(Users::class, 'user_code', 'code');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(Users::class, 'updated_by', 'code');
    }

    public function deletedByUser()
    {
        return $this->belongsTo(Users::class, 'deleted_by', 'code');
    }

    public function browseByUser()
    {
        return $this->belongsTo(Users::class, 'browse_by', 'code');
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
