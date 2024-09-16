<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt_details extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'code',
        'receipt_code',
        'batch_number',
        'expire_date',
        'quantity',
        'price',
        'discount',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
