<?php

namespace App\Services;

use App\Repositories\PeliculaSalacineRepository;
use Carbon\Carbon;


class PeliculaSalacineService
{
    protected $peliculaSalacineRepository;

    public function __construct(PeliculaSalacineRepository $peliculaSalacineRepository)
    {
        $this->peliculaSalacineRepository = $peliculaSalacineRepository;
    }

    public function getAllPeliculaSalacine()
    {
        return $this->peliculaSalacineRepository->getAll();
    }

    public function getPeliculaSalacineById($id)
    {
        return $this->peliculaSalacineRepository->find($id);
    }

    public function searchMovieByNameAndRoom($nombre, $idSala)
    {
        return $this->peliculaSalacineRepository->searchMovieByNameAndRoom($nombre, $idSala);
    }

    public function getQuantityMoviesPublishedBeforeDate($fechaString){
        $fecha = Carbon::parse($fechaString); // Convierte la cadena de fecha en un objeto Carbon
        return $this->peliculaSalacineRepository->getQuantityMoviesPublishedBeforeDate($fecha);
    }

    public function getMovieCountByCinemaName($nombreSala)
    {
        return $this->peliculaSalacineRepository->getMovieCountByCinemaName($nombreSala);
    }

    public function createPeliculaSalacine($data)
    {
        return $this->peliculaSalacineRepository->create($data);
    }

    public function updatePeliculaSalacine($id, $data)
    {
        return $this->peliculaSalacineRepository->update($id, $data);
    }

    public function deletePeliculaSalacine($id)
    {
        return $this->peliculaSalacineRepository->delete($id);
    }
}
