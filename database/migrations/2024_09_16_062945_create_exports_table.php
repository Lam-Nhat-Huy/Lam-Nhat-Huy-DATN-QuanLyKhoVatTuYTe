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
            $table->char('department_code', 10)->nullable();
            $table->text('note')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamp('export_date')->nullable();
            $table->char('export_request_code', 10)->nullable();
            $table->string('export_type', 55)->nullable();
            $table->char('created_by', 10)->nullable();
            $table->char('updated_by', 10)->nullable();
            $table->char('deleted_by', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('department_code')->references('code')->on('departments')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exports');
    }
};
