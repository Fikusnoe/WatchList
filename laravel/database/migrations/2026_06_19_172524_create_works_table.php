<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['movie', 'series', 'game', 'book']);
            $table->string('genre', 100)->nullable();
            $table->integer('release_year');
            $table->string('author')->nullable();
            $table->text('description')->nullable();
            $table->string('poster_url', 500)->nullable();
            $table->timestamps();

            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};