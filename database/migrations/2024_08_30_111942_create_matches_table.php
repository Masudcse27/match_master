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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Tournament_id')->nullable()->constrained('tournaments')->onDelete('cascade');
            $table->foreignId('venu_id')->nullable()->constrained('grounds')->onDelete('set null');
            $table->foreignId('team_1')->constrained('teams')->onDelete('cascade');
            $table->foreignId('team_2')->nullable()->constrained('teams')->onDelete('cascade');
            $table->integer('team_1_total_run')->default('0')->index();
            $table->integer('team_2_total_run')->default('0')->index();
            $table->integer('team_1_wickets')->default('0')->index();
            $table->integer('team_2_wickets')->default('0')->index();
            $table->boolean('is_end')->default(false);
            $table->date('match_date')->nullable();
            $table->time('start_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
