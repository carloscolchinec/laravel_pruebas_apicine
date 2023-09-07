<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeliculaTable extends Migration
{
    public function up()
    {
        Schema::create('pelicula', function (Blueprint $table) {
            $table->id('id_pelicula');
            $table->string('nombre');
            $table->integer('duracion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelicula');
    }
}
