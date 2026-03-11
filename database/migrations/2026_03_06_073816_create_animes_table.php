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
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_url')->nullable();
            $table->decimal('score', 3, 1)->nullable();
            $table->integer('rank')->nullable();
            $table->integer('popularity')->nullable();
            $table->string('format')->nullable(); // e.g., TV Series
            $table->integer('episodes')->nullable();
            $table->string('status'); // e.g., Watching, Plan to watch, Completed
            $table->string('season')->nullable(); // e.g., Spring 2024
            $table->json('genres')->nullable();
            $table->integer('user_rating')->default(0); // 0-5
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
