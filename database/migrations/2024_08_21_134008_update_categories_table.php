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
        //
        /*
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('movement_type_id')->references('id')->on('movement_types');
        });
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
