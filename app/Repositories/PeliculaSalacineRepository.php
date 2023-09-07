<?php

namespace App\Repositories;

use App\Models\PeliculaSalacine;

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
