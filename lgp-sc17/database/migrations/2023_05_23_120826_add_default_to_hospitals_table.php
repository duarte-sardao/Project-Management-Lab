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
        Schema::table('hospitals', function (Blueprint $table) {
            //
        });

        // Insert first hospital
        DB::table('hospitals')->insert(
            array(
                'name' => 'Centro Hospitalar Universitário São João',
                'updated_at' => now(),
                'created_at' => now(),
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospitals', function (Blueprint $table) {
            //
        });

        DB::table('hospitals')->where(
            'name',
            '=',
            'Centro Hospitalar Universitário São João'
        )->delete();
    }
};
