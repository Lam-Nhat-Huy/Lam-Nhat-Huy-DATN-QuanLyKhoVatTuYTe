<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->char('code', 10)->primary();
            $table->char('supplier_code', 20);
            $table->text('note')->nullable();
            $table->boolean('status')->default(false);
            $table->char('order_number', 10)->nullable();
            $table->char('receipt_no', 8);
            $table->timestamp('receipt_date')->nullable();
            $table->string('receipt_type', 55)->nullable();
            $table->char('created_by', 10);
            $table->char('updated_by', 10)->nullable();
            $table->char('deleted_by', 10)->nullable();
            $table->char('browse_by', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('receipts');
    }
};
