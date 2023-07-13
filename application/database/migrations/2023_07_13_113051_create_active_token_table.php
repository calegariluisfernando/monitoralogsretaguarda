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
        Schema::create('active_token', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->string('token');
            $table->timestamps();
        });

        Schema::table('active_token', function (Blueprint $table) {
            $table->index('token');
            $table->index('created_at');

            $table->foreign('user_id')->references('id')->on('users');
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('active_token', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['token']);
            $table->dropIndex(['created_at']);
        });

        Schema::dropIfExists('active_token');
    }
};
