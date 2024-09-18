<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->char('code', 20)->primary();
            $table->string('name', 255);
            $table->char('barcode', 255)->nullable();
            $table->text('description')->nullable();
            $table->integer('price')->nullable();
            $table->string('country', 255)->nullable();
            $table->char('equipment_type_code', 20)->nullable();
            $table->char('supplier_code', 20)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('equipment_type_code')->references('code')->on('equipment_types')->onDelete('set null');
            $table->foreign('supplier_code')->references('code')->on('suppliers')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipments');
    }
};
