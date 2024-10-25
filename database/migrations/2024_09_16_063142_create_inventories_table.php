<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->char('code', 10)->primary();
            $table->char('equipment_code', 10)->nullable();
            $table->char('batch_number', 10);
            $table->integer('current_quantity')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('equipment_code')->references('code')->on('equipments')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventories');
    }
};
