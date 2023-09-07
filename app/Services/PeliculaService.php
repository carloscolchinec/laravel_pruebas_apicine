<?php

namespace App\Services;

use App\Repositories\PeliculaRepository;

class PeliculaService
{
    protected $peliculaRepository;

    public function __construct(PeliculaRepository $peliculaRepository)
    {
        $this->peliculaRepository = $peliculaRepository;
    }

    public function getAllPeliculas()
    {
        return $this->peliculaRepository->getAll();
    }

    public function getPeliculaById($id)
    {
        return $this->peliculaRepository->find($id);
    }

    public function createPelicula($data)
    {
        return $this->peliculaRepository->create($data);
    }

    public function updatePelicula($id, $data)
    {
        return $this->peliculaRepository->update($id, $data);
    }

    public function deletePelicula($id)
    {
        return $this->peliculaRepository->delete($id);
    }
}
