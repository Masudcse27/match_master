<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('matches', function (Blueprint $table) {
            // Modify default values for columns
            $table->integer('team_1_total_run')->default(10)->change(); // Change to 10 or desired value
            $table->integer('team_2_total_run')->default(10)->change(); // Change to 10 or desired value
            $table->integer('team_1_wickets')->default(0)->change();    // Change to 1 or desired value
            $table->integer('team_2_wickets')->default(0)->change();    // Change to 1 or desired value
            $table->boolean('is_end')->default(false)->change();         // Change to true or desired value
        });
    }

    public function down()
    {
        Schema::table('matches', function (Blueprint $table) {
            // Revert the changes if needed
            $table->integer('team_1_total_run')->default(0)->change();
            $table->integer('team_2_total_run')->default(0)->change();
            $table->integer('team_1_wickets')->default(0)->change();
            $table->integer('team_2_wickets')->default(0)->change();
            $table->boolean('is_end')->default(false)->change();
        });
    }
};
