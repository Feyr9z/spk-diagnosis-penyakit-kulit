<?php

namespace App\Services;

use App\Models\Penyakit;

class PenyakitService
{
    public function getAll()
    {
        return Penyakit::orderBy('kode_penyakit')->get();
    }

    public function findById(int $id): ?Penyakit
    {
        return Penyakit::find($id);
    }

    public function store(array $data): Penyakit
    {
        return Penyakit::create($data);
    }

    public function update(Penyakit $penyakit, array $data): Penyakit
    {
        $penyakit->fill($data);
        $penyakit->save();

        return $penyakit;
    }

    public function delete(Penyakit $penyakit): bool
    {
        return $penyakit->delete();
    }
}
