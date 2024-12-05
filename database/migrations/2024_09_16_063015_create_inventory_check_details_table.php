<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventory_check_details', function (Blueprint $table) {
            $table->id(); // ID tự tăng
            $table->char('inventory_check_code', 10)->nullable(); // Mã phiếu kiểm kho
            $table->char('equipment_code', 10)->nullable(); // Mã thiết bị
            $table->integer('current_quantity')->nullable(); // Số lượng hiện tại trong kho
            $table->integer('actual_quantity')->nullable(); // Số lượng thực tế đếm được
            $table->integer('unequal')->nullable(); // Chênh lệch
            $table->char('batch_number', 10); // Mã lô hàng
            $table->text('equipment_note')->nullable(); // Ghi chú thiết bị
            $table->integer('check_round')->default(1); // Lần kiểm (thêm mới)
            $table->timestamps(); // Ngày tạo và cập nhật
            $table->softDeletes(); // Xóa mềm

            $table->foreign('inventory_check_code')->references('code')->on('inventory_checks')->onDelete('set null');
            $table->foreign('equipment_code')->references('code')->on('equipments')->onDelete('set null');
        });
    }


    public function down()
    {
        Schema::dropIfExists('inventory_check_details');
    }
};