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
            $table->foreignId('comic_id')->constrained()->onDelete('cascade');
            $table->foreignId('genre_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comic_genre');
    }
}
