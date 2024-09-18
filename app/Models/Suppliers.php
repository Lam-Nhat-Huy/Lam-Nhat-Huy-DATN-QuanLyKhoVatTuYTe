<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'contact_name',
        'tax_code',
        'email',
        'phone',
        'address',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function receipts()
    {
        return $this->hasMany(Receipts::class, 'supplier_code', 'code');
    }
}
