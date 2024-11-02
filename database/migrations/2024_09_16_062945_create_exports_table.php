<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exports', function (Blueprint $table) {
            $table->char('code', 10)->primary();
            $table->text('note')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamp('export_date')->nullable();
            $table->timestamp('required_date')->nullable();
            $table->string('export_type', 20)->nullable();
            $table->char('department_code', 10)->nullable();
            $table->char('supplier_code', 10)->nullable();
            $table->string('reason', 50)->nullable();
            $table->char('export_request_code', 10)->nullable();
            $table->char('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('department_code')->references('code')->on('departments')->onDelete('set null');
            $table->foreign('supplier_code')->references('code')->on('suppliers')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exports');
    }
};
