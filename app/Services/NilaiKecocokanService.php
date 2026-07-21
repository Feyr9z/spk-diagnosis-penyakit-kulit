<?php

namespace App\Services;

use App\Models\Gejala;
use App\Models\NilaiKecocokan;
use App\Models\Penyakit;

class NilaiKecocokanService
{
    public function getAll()
    {
        return NilaiKecocokan::with(['penyakit', 'gejala'])
            ->orderBy('penyakit_id')
            ->orderBy('gejala_id')
            ->get();
    }

    public function findById(int $id): ?NilaiKecocokan
    {
        return NilaiKecocokan::with(['penyakit', 'gejala'])->find($id);
    }

    public function getAllPenyakit()
    {
        return Penyakit::orderBy('kode_penyakit')->get(['id', 'kode_penyakit', 'nama_penyakit']);
    }

    public function getAllGejala()
    {
        return Gejala::orderBy('kode_gejala')->get(['id', 'kode_gejala', 'nama_gejala']);
    }

    public function store(array $data): NilaiKecocokan
    {
        return NilaiKecocokan::create($data);
    }

    public function update(NilaiKecocokan $nilaiKecocokan, array $data): NilaiKecocokan
    {
        $nilaiKecocokan->fill($data);
        $nilaiKecocokan->save();

        return $nilaiKecocokan;
    }

    public function delete(NilaiKecocokan $nilaiKecocokan): bool
    {
        return $nilaiKecocokan->delete();
    }
}
