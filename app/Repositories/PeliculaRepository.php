<?php

namespace App\Repositories;

use App\Models\Pelicula;

class PeliculaRepository
{
    public function getAll()
    {
        return Pelicula::all();
    }

    public function find($id)
    {
        return Pelicula::find($id);
    }

    public function create($data)
    {
        return Pelicula::create($data);
    }

    public function update($id, $data)
    {
        $pelicula = Pelicula::find($id);
        if ($pelicula) {
            $pelicula->update($data);
            return $pelicula;
        }
        return null;
    }

    public function delete($id)
    {
        $pelicula = Pelicula::find($id);
        if ($pelicula) {
            $pelicula->delete();
            return true;
        }
        return false;
    }
}
