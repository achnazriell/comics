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
            $table->foreignId('comic_id')->constrained()->onDelete('cascade');
            $table->text('synopsis');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('synopsis');
    }
}
