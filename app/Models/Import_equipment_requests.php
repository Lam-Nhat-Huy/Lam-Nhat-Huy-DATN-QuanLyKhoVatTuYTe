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
        'supplier_code',
        'note',
        'status',
        'request_date',
        'reason_refuse',
        'allow_to_edit',
        'created_at',
        'user_code',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
        'browse_by',
        'update_quote_by'
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

    public function updateQuoteByUser()
    {
        return $this->belongsTo(Users::class, 'update_quote_by', 'code');
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
