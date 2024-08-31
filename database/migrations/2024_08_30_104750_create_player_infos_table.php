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
        Schema::create('player_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->enum('player_type', ['batter','bowler','wk_batter','batting_all','bowling_all']);
            $table->string('address')->nullable();
            $table->integer('total_match')->default(0);
            $table->integer('total_run')->default(0);
            $table->integer('total_wicket')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_infos');
    }
};
