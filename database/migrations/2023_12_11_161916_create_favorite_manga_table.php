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
        Schema::create('favorite_manga', function (Blueprint $table) {
            $table->primary(['user_id', 'manga_id']);
            //unsignedBigInteger = foreignId
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('manga_id');
            //the combined primary key must be unique
            $table->timestamps();

            // Foreign keys constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('manga_id')->references('id')->on('mangas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_manga');
    }
};
