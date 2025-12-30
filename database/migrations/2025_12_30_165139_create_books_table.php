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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->json('title'); // {"sk": "...", "en": "..."}
            $table->string('cover')->nullable();
            $table->integer('publishing_year');
            $table->json('publishing_house'); // {"sk": "...", "en": "..."}
            $table->json('description'); // {"sk": "...", "en": "..."}
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
