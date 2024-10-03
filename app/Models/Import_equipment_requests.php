<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Import_equipment_requests extends Model
{
    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'code',
        'user_code',
        'supplier_code',
        'note',
        'status',
        'request_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function users()
    {
        return $this->belongsTo(Users::class, 'user_code', 'code');
    }

    public function suppliers()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_code', 'code');
    }

    public function import_equipment_request_details()
    {
        return $this->hasMany(Import_equipment_request_details::class, 'import_request_code', 'code');
    }
}
