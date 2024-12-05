<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('import_equipment_requests', function (Blueprint $table) {
            $table->char('code', 10)->primary();
            $table->char('supplier_code', 10)->nullable();
            $table->text('note')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamp('request_date')->nullable();
            $table->text('reason_refuse')->nullable();
            $table->boolean('allow_to_edit')->default(false);
            $table->char('user_code', 10)->nullable();
            $table->char('updated_by', 10)->nullable();
            $table->char('deleted_by', 10)->nullable();
            $table->char('browse_by', 10)->nullable();
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
