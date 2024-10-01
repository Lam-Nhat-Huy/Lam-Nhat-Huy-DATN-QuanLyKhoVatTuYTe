<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suppliers extends Model
{
    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';
    use HasFactory, SoftDeletes;
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
