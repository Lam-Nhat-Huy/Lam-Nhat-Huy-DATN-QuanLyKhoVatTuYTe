<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->char('code', 20)->primary();
            $table->text('note')->nullable();
            $table->boolean('status')->default(true);
            $table->string('receipt_no')->nullable();
            $table->date('receipt_date')->nullable();
            $table->char('created_by', 20)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('code')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('receipts');
    }
};
