<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exports extends Model
{
    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'code',
        'note',
        'status',
        'export_date',
        'required_date',
        'export_type',
        'department_code',
        'supplier_code',
        'reason',
        'export_request_code',
        'created_by',
        'updated_by',
        'browse_by',
        'deleted_by',
        'updated_at',
        'deleted_at'
    ];

    public function exportDetail()
    {
        return $this->hasMany(Export_details::class, 'export_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'created_by', 'code');
    }

    public function departments()
    {
        return $this->belongsTo(Departments::class, 'department_code', 'code');
    }

    public function suppliers()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_code', 'code');
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
}
