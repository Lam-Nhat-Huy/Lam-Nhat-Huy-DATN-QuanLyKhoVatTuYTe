<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->char('code', 20)->primary();
            $table->char('batch_number', 20)->nullable();
            $table->integer('current_quantity')->nullable();
            $table->char('import_code', 20)->nullable()->nullable();
            $table->char('export_code', 20)->nullable()->nullable();
            $table->char('unit_code', 20)->nullable()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('import_code')->references('code')->on('receipts')->onDelete('set null');
            $table->foreign('export_code')->references('code')->on('exports')->onDelete('set null');
            $table->foreign('unit_code')->references('code')->on('units')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventories');
    }
};
