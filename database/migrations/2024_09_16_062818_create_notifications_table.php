<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->char('code', 10)->primary();
            $table->boolean('notification_type');
            $table->text('content');
            $table->boolean('important')->default(false);
            $table->boolean('status')->default(false);
            $table->boolean('lock_warehouse')->default(false);
            $table->boolean('is_read')->default(false);
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
        Schema::dropIfExists('notifications');
    }
};
