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
        Schema::create('black_list_token', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('token', 500);
            $table->timestamps();
        });

        Schema::table('black_list_token', function (Blueprint $table) {
            $table->index('token');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('black_list_token', function (Blueprint $table) {
            $table->dropIndex(['token']);
            $table->dropIndex(['created_at']);
        });

        Schema::dropIfExists('black_list_token');
    }
};
