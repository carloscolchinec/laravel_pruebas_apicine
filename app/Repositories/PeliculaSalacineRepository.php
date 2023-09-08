<?php

namespace App\Repositories;

use App\Models\Pelicula;
use App\Models\PeliculaSalacine;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeliculaSalacineRepository
{
    public function getAll()
    {
        return PeliculaSalacine::all();
    }

    public function find($id)
    {
        return PeliculaSalacine::find($id);
    }

    public function searchMovieByNameAndRoom($nombre, $idSala)
    {
        return DB::table('pelicula as p')
            ->join('pelicula_salacine as ps', 'p.id_pelicula', '=', 'ps.id_pelicula')
            ->join('sala_cine as sc', 'ps.id_sala_cine', '=', 'sc.id_sala')
            ->where('p.nombre', $nombre)
            ->where('sc.id_sala', $idSala)
            ->select('p.*')
            ->first();
    }
    
    public function getQuantityMoviesPublishedBeforeDate(Carbon $fecha)
    {
        return PeliculaSalacine::whereDate('fecha_publicacion', '<=', $fecha)
        ->whereDate('fecha_fin', '>=', $fecha)
        ->get();
    }
    

    public function getMovieCountByCinemaName($nombreSala)
    {
        return DB::table('peliculas_salacine')
            ->join('salas_cine', 'peliculas_salacine.id_sala_cine', '=', 'salas_cine.id_sala')
            ->where('salas_cine.nombre', $nombreSala)
            ->count();
    }
    

    public function create($data)
    {
        return PeliculaSalacine::create($data);
    }

    public function update($id, $data)
    {
        $peliculaSalacine = PeliculaSalacine::find($id);
        if ($peliculaSalacine) {
            $peliculaSalacine->update($data);
            return $peliculaSalacine;
        }
        return null;
    }

    public function delete($id)
    {
        $peliculaSalacine = PeliculaSalacine::find($id);
        if ($peliculaSalacine) {
            $peliculaSalacine->delete();
            return true;
        }
        return false;
    }
}
