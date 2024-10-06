<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->char('code', 20)->primary();
            $table->string('name', 255)->unique();
            $table->text('description')->nullable();
            $table->char('created_by', 20)->nullable();;
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('created_by')->references('code')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('units');
    }
};
