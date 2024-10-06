<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Units extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $primaryKey = 'code'; // Chỉ định 'code' là khóa chính

    public $incrementing = false; // Nếu 'code' không phải là auto-increment

    protected $keyType = 'string'; // Nếu 'code' là kiểu chuỗi

    protected $fillable = [
        'code',
        'name',
        'description',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function equipments()
    {
        return $this->hasMany(Equipments::class, 'unit_code', 'code');
    }

    public function users()
    {
        return $this->belongsTo(Users::class, 'created_by', 'code');
    }
}
