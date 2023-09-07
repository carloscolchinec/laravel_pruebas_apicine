<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeliculaSalacine extends Model
{
    use HasFactory;

    protected $table = 'pelicula_salacine';
    protected $primaryKey = 'id_pelicula_sala';
    protected $fillable = ['id_sala_cine', 'fecha_publicacion', 'fecha_fin', 'id_pelicula'];
}
