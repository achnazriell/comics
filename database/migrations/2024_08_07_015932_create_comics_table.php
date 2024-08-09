<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComicsTable extends Migration
{
    public function up()
    {
        Schema::create('comics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('author_id')->constrained()->onDelete('cascade');
            $table->foreignId('publisher_id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable(); // Adding image column
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comics');
    }
}
