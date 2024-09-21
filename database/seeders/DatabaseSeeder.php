<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Inventories;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            NotificationsSeeder::class,
            DepartmentsSeeder::class,
            EquipmentTypesSeeder::class,
            UnitsSeeder::class,
            EquipmentsSeeder::class,
            SuppliersSeeder::class,
            ReceiptsSeeder::class,
            ReceiptDetailsSeeder::class,
            ExportsSeeder::class,
            ExportDetailsSeeder::class,
            InventoryChecksSeeder::class,
            InventoryCheckDetailsSeeder::class,
            ImportEquipmentRequestsSeeder::class,
            ImportEquipmentRequestDetailsSeeder::class,
            ExportEquipmentRequestsSeeder::class,
            ExportEquipmentRequestDetailsSeeder::class,
            InventoriesSeeder::class
        ]);
    }
}
