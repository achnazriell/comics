<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSynopsisTable extends Migration
{
    public function up()
    {
        Schema::create('synopsis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comic_id');
            $table->text('content');
            $table->timestamps();
        
            $table->foreign('comic_id')->references('id')->on('comics')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('synopsis');
    }
}
