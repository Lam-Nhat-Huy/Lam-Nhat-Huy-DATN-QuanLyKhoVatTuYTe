<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   Receipt_details extends Model
{
    use HasFactory;

    protected $fillable = [
        'int',
        'receipt_code',
        'equipment_code',
        'batch_number',
        'quantity',
        'quantity_quote',
        'deviation_quote',
        'VAT',
        'discount',
        'price',
    ];

    public function receipt()
    {
        return $this->belongsTo(Receipts::class, 'receipt_code', 'code');
    }

    public function equipments()
    {
        return $this->belongsTo(Equipments::class, 'equipment_code', 'code');
    }
}
