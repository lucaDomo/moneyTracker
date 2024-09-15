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
        
        Schema::create('movement_types', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('name'); //spesa - guadagno
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id('private_id')->primary();
            $table->uuid('id')->unique();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('name');
            $table->string('file')->nullable();
            $table->foreignId('movement_type_id')->references('id')->on('movement_types');
            $table->timestamps();
        });
        
        Schema::create('movements', function (Blueprint $table) {
            $table->id('private_id')->primary();
            $table->uuid('id')->unique();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('category_id')->references('private_id')->on('categories');
            $table->foreignId('movement_type_id')->references('id')->on('movement_types');
            $table->string('name');
            $table->integer('week_number');
            $table->integer('day_number');
            $table->integer('month_number');
            $table->integer('year');
            $table->date('date');
            $table->float('money');
            $table->string('file')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movements', function (Blueprint $table)
        {
            $table->dropForeign('category_id');
            $table->dropForeign('user_id');
            $table->dropForeign('movement_type_id');
            $table->dropColumn('category_id');
        });
        Schema::table('categories', function (Blueprint $table)
        {
            $table->dropForeign('user_id');
            $table->dropForeign('movement_type_id');
        });
        Schema::dropIfExists('categories');
        Schema::dropIfExists('movements');
    }
};
