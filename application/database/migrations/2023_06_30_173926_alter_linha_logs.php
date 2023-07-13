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
        Schema::table('linha_logs', function (Blueprint $table){
            $table->dropColumn('error_text');
        });
        Schema::table('linha_logs', function (Blueprint $table){
            $table->text('error_text')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('linha_logs', function (Blueprint $table){
            $table->dropColumn('error_text');
        });
        Schema::table('linha_logs', function (Blueprint $table){
            $table->string('error_text', 1000)->nullable(false);
        });
    }
};
