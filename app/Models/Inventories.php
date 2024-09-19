<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventories extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'inventories';

    protected $fillable = [
        'code',
        'equipment_code',
        'batch_number',
        'current_quantity',
        'import_code',
        'export_code',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function equipments()
    {
        return $this->belongsTo(Equipments::class, 'equipment_code', 'code');
    }

    // Dùng này để lấy ra vật tư và số lượng bên controller
    // $inventories = Inventories::with('equipments')->get();
    // foreach ($inventories as $inventory) {
    //     echo 'Equipment Name: ' . $inventory->equipments->name . '<br>';
    //     echo 'Batch Number: ' . $inventory->batch_number . '<br>';
    //     echo 'Current Quantity: ' . $inventory->current_quantity . '<br>';
    //     echo "<hr>";
    // }
}
