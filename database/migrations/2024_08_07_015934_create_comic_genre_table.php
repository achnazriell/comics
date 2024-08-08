<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComicGenreTable extends Migration
{
    public function up()
    {
        Schema::create('comic_genre', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comic_id');
            $table->unsignedBigInteger('genre_id');
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('comic_id')->references('id')->on('comics')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            
            // Add a unique constraint to prevent duplicate entries
            $table->unique(['comic_id', 'genre_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('comic_genre');
    }
}
