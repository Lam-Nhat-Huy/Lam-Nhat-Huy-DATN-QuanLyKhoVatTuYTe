<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment_types extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $table = 'equipment_types';

    protected $primaryKey = 'code'; // Chỉ định 'code' là khóa chính
    public $incrementing = false; // Nếu 'code' không phải là auto-increment
    protected $keyType = 'string'; // Nếu 'code' là kiểu chuỗi

    protected $fillable = [
        'code',
        'name',
        'description', // Thêm cột mô tả
        'status', // Thêm cột trạng thái
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
