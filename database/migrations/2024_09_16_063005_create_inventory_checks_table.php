<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventory_checks', function (Blueprint $table) {
            $table->char('code', 10)->primary();
            $table->char('recheck_created_by', 20)->nullable();
            $table->timestamp('check_date')->nullable();
            $table->text('note')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('check_count')->default(1);
            $table->char('created_by', 10)->nullable();
            $table->char('updated_by', 10)->nullable();
            $table->char('deleted_by', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('code')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_checks');
    }
};
