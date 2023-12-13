<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//A migration class contains two methods: up and down.
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //the up method is used to add new tables, columns, or indexes to the database
    public function up(): void
    {
        Schema::create('mangas', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->enum('status', ['ongoing', 'completed', 'dropped']);
            $table->text('description');
            $table->string('picture', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    //down method should reverse the operations performed by the up method.
    public function down(): void
    {
        Schema::dropIfExists('mangas');
    }
};
