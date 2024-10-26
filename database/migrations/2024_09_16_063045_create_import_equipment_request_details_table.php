<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('import_equipment_request_details', function (Blueprint $table) {
            $table->id();
            $table->char('equipment_code', 10)->nullable();
            $table->char('import_request_code', 10)->nullable();
            $table->integer('quantity');
            $table->integer('quantity_quote')->nullable();
            $table->string('deviation_quote', 20)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('equipment_code')->references('code')->on('equipments')->onDelete('set null');
            $table->foreign('import_request_code')->references('code')->on('import_equipment_requests')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('import_equipment_request_details');
    }
};
