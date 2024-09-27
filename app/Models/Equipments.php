<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipments extends Model
{
    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    use HasFactory;

    protected $table = 'equipments';

    protected $primaryKey = 'code'; // Chỉ định 'code' là khóa chính
    public $incrementing = false; // Nếu 'code' không phải là auto-increment
    protected $keyType = 'string'; // Nếu 'code' là kiểu chuỗi

    protected $fillable = [
        'code',
        'name',
        'barcode',
        'description',
        'price',
        'country',
        'equipment_type_code',
        'supplier_code',
        'unit_code',
        'image',
        'expiry_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Định nghĩa mối quan hệ với Inventories
    public function inventories()
    {
        return $this->hasMany(Inventories::class, 'equipment_code', 'code');
    }

    // Định nghĩa mối quan hệ với Units
    public function units()
    {
        return $this->belongsTo(Units::class, 'unit_code', 'code');
    }

    // Định nghĩa mối quan hệ với Suppliers
    public function supplier()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_code', 'code');
    }

    // Định nghĩa mối quan hệ với Equipment_types
    public function equipmentType()
    {
        return $this->belongsTo(Equipment_types::class, 'equipment_type_code', 'code');
    }
}

