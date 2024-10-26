<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('receipt_details', function (Blueprint $table) {
            $table->id();
            $table->char('receipt_code', 10);
            $table->char('equipment_code', 10)->nullable();
            $table->char('batch_number', 10);
            $table->integer('quantity');
            $table->integer('quantity_quote');
            $table->string('deviation_quote', 20);
            $table->decimal('VAT', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('price', 10, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('receipt_code')->references('code')->on('receipts')->onDelete('cascade');
            $table->foreign('equipment_code')->references('code')->on('equipments')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('receipt_details');
    }
};
