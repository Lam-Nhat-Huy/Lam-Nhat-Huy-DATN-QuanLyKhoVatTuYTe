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
            $table->date('receipt_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('receipts');
    }
};
