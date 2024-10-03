<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('import_equipment_requests', function (Blueprint $table) {
            $table->char('code', 20)->primary();
            $table->char('user_code', 20)->nullable();
            $table->char('supplier_code', 20)->nullable();
            $table->text('note')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamp('request_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_code')->references('code')->on('users')->onDelete('set null');
            $table->foreign('supplier_code')->references('code')->on('suppliers')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('import_equipment_requests');
    }
};
