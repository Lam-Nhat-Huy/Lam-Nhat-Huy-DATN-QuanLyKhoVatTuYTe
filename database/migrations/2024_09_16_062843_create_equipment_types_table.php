<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('equipment_types', function (Blueprint $table) {
            $table->char('code', 20)->primary();
            $table->string('name', 255);
            $table->text('description')->nullable(); // Thêm cột mô tả sau cột 'name'
            $table->boolean('status')->default(true); // Thêm cột trạng thái sau cột 'description'
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment_types');
    }
};
