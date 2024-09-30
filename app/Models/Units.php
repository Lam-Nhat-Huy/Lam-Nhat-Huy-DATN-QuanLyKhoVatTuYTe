<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Units extends Model
{
    protected $primaryKey = 'code';

    public $incrementing = false;

    protected $keyType = 'string';

    use HasFactory;

    use SoftDeletes;
    protected $table = 'units';

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
}
