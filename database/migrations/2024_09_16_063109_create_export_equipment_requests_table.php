<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('export_equipment_requests', function (Blueprint $table) {
            $table->char('code', 20)->primary();
            $table->char('department_code', 20)->nullable();
            $table->text('reason_export')->nullable();
            $table->text('note')->nullable();
            $table->date('request_date')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('department_code')->references('code')->on('departments')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('export_equipment_requests');
    }
};
