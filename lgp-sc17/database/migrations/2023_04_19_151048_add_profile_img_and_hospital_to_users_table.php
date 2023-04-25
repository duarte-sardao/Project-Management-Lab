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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_img_url')->nullable();
        });
        Schema::table('patients', function (Blueprint $table) {
            $table->unsignedBigInteger('hospital_id')->default(1);

            $table->foreign('hospital_id')->references('id')->on('hospitals');
        });
        Schema::table('medics', function (Blueprint $table) {
            $table->unsignedBigInteger('hospital_id')->default(1);

            $table->foreign('hospital_id')->references('id')->on('hospitals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_img_url');
        });
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign('hospital_id');
        });
        Schema::table('medics', function (Blueprint $table) {
            $table->dropForeign('hospital_id');
        });
    }
};
