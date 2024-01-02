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
        Schema::create('authors_mangas', function (Blueprint $table) {
            $table->primary(['manga_id', 'author_id']);
            //unsignedBigInteger = foreignId
            $table->unsignedBigInteger('manga_id');
            $table->unsignedBigInteger('author_id');

            // Foreign keys constraints
            $table->foreign('manga_id')->references('id')->on('mangas')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors_mangas');
    }
};
