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
        Schema::create('grounds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('cost_per_day')->default(0);
            $table->string('ground_location');
            $table->string('description');
            $table->enum('is_approved',['pending','approved','rejected'])->default('pending');
            $table->boolean('is_exist')->default(false);
            $table->foreignId('authority_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grounds');
    }
};
