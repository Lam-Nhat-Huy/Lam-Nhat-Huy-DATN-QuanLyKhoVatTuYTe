<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipts extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'supplier_code',
        'note',
        'status',
        'order_number',
        'receipt_no',
        'receipt_date',
        'receipt_type',
        'reason_refuse',
        'created_by',
        'updated_by',
        'browse_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function details()
    {
        return $this->hasMany(Receipt_details::class, 'receipt_code', 'code');
    }

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_code', 'code');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'created_by', 'code');
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
