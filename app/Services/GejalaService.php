<?php

namespace App\Services;

use App\Models\Gejala;

class GejalaService
{
    public function getAll()
    {
        return Gejala::orderBy('kode_gejala')->get();
    }

    public function findById(int $id): ?Gejala
    {
        return Gejala::find($id);
    }

    public function store(array $data): Gejala
    {
        return Gejala::create($data);
    }

    public function update(Gejala $gejala, array $data): Gejala
    {
        $gejala->fill($data);
        $gejala->save();

        return $gejala;
    }

    public function delete(Gejala $gejala): bool
    {
        return $gejala->delete();
    }
}
