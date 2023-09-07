<?php

namespace App\Services;

use App\Repositories\PeliculaSalacineRepository;

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
