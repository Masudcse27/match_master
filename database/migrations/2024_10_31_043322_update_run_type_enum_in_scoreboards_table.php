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
        Schema::table('scoreboards', function (Blueprint $table) {
            DB::statement("ALTER TABLE scoreboards MODIFY COLUMN run_type ENUM('no', 'lb', 'w', 'lbw', 'rw', 'b', 'wd')");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scoreboards', function (Blueprint $table) {
            DB::statement("ALTER TABLE scoreboards MODIFY COLUMN run_type ENUM('no', 'lb', 'w', 'lbw', 'rw', 'b','wd')");
        });
    }
};
