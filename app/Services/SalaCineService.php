<?php

namespace App\Services;

use App\Repositories\SalaCineRepository;

class SalaCineService
{
    protected $salaCineRepository;

    public function __construct(SalaCineRepository $salaCineRepository)
    {
        $this->salaCineRepository = $salaCineRepository;
    }

    public function getAllSalasCine()
    {
        return $this->salaCineRepository->getAll();
    }

    public function getSalaCineById($id)
    {
        return $this->salaCineRepository->find($id);
    }

    public function createSalaCine($data)
    {
        return $this->salaCineRepository->create($data);
    }

    public function updateSalaCine($id, $data)
    {
        return $this->salaCineRepository->update($id, $data);
    }

    public function deleteSalaCine($id)
    {
        return $this->salaCineRepository->delete($id);
    }
}
