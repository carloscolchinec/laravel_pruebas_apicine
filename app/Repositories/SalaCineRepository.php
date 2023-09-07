<?php

namespace App\Repositories;

use App\Models\SalaCine;

class SalaCineRepository
{
    public function getAll()
    {
        return SalaCine::all();
    }

    public function find($id)
    {
        return SalaCine::find($id);
    }

    public function create($data)
    {
        return SalaCine::create($data);
    }

    public function update($id, $data)
    {
        $salaCine = SalaCine::find($id);
        if ($salaCine) {
            $salaCine->update($data);
            return $salaCine;
        }
        return null;
    }

    public function delete($id)
    {
        $salaCine = SalaCine::find($id);
        if ($salaCine) {
            $salaCine->delete();
            return true;
        }
        return false;
    }
}
