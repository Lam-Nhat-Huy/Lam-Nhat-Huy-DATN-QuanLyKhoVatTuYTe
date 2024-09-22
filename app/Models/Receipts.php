<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipts extends Model
{
    use HasFactory;

    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'supplier_code',
        'note',
        'status',
        'receipt_date',
        'receipt_no',
        'created_by',
        'created_at',
        'updated_at',
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
}
