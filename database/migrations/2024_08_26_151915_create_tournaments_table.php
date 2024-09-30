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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('manager_id')->constrained('users')->onDelete('cascade');
            $table->integer('number_of_team')->default(0);
            $table->string('description')->nullable(true);
            $table->date('registration_last_date')->nullable(true);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('entry_fee')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
