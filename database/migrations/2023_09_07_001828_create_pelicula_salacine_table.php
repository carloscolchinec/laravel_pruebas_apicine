<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeliculaSalacineTable extends Migration
{
    public function up()
    {
        Schema::create('pelicula_salacine', function (Blueprint $table) {
            $table->id('id_pelicula_sala');
            $table->unsignedBigInteger('id_sala_cine');
            $table->date('fecha_publicacion');
            $table->date('fecha_fin');
            $table->unsignedBigInteger('id_pelicula');
            $table->timestamps();

            $table->foreign('id_sala_cine')->references('id_sala')->on('sala_cine');
            $table->foreign('id_pelicula')->references('id_pelicula')->on('pelicula');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelicula_salacine');
    }
}
