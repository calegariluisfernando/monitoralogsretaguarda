<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('linha_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('log_id')->nullable(false);
            $table->timestamps();
            $table->string('error_text', 1000)->nullable(false);
        });

        Schema::table('linha_logs', function (Blueprint $table) {
            $table->foreign('log_id')
                ->references('id')
                ->on('logs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('linha_logs', function (Blueprint $table) {
            $table->dropForeign(['log_id']);
        });
        Schema::dropIfExists('linha_logs');
    }
};
