<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaCineTable extends Migration
{
    public function up()
    {
        Schema::create('sala_cine', function (Blueprint $table) {
            $table->id('id_sala');
            $table->string('nombre');
            $table->string('estado');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sala_cine');
    }
}
