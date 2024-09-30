<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment_types extends Model
{
    use HasFactory, SoftDeletes; // Sử dụng SoftDeletes một lần

    protected $table = 'equipment_types';

    // Chỉ định 'code' là khóa chính
    protected $primaryKey = 'code';
    public $incrementing = false; // Khóa chính không tự động tăng
    protected $keyType = 'string'; // Định nghĩa kiểu dữ liệu của khóa chính là chuỗi

    // Các cột có thể được gán tự động
    protected $fillable = [
        'code',
        'name',
        'description', // Cột mô tả
        'status', // Cột trạng thái
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Các cột cần được xử lý ngày tháng
    protected $dates = ['deleted_at'];
}
