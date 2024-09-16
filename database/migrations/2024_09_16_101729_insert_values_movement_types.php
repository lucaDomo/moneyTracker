<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        // Insert some stuff
        DB::table('movement_types')->insert(
            array(
                'name' => 'Expenses',
            )
        );
        DB::table('movement_types')->insert(
            array(
                'name' => 'Earnings',
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
