<?php

namespace App\Services;

use App\Models\Diagnosis;
use App\Models\Gejala;
use App\Models\Pasien;
use Illuminate\Support\Facades\DB;

class DiagnosisService
{
    public function __construct(
        protected SAWService $sawService
    ) {}

    public function getAllGejala()
    {
        return Gejala::orderBy('kode_gejala')->get(['id', 'kode_gejala', 'nama_gejala', 'bobot']);
    }

    public function proses(array $pasienData, array $selectedGejalaIds): Diagnosis
    {
        return DB::transaction(function () use ($pasienData, $selectedGejalaIds) {
            // 1. Simpan Pasien
            $pasien = Pasien::create([
                'nama'          => $pasienData['nama'],
                'jenis_kelamin' => $pasienData['jenis_kelamin'],
                'usia'          => $pasienData['usia'],
            ]);

            // 2. Hitung SAW
            $hasilSAW = $this->sawService->hitung($selectedGejalaIds);

            // 3. Simpan Diagnosis
            $diagnosis = Diagnosis::create([
                'pasien_id'        => $pasien->id,
                'penyakit_id'      => $hasilSAW['penyakit']->id,
                'nilai_preferensi' => $hasilSAW['nilai_preferensi'],
            ]);

            // 4. Simpan Detail Diagnosis
            $detailData = array_map(
                fn ($gejalaId) => [
                    'diagnosis_id' => $diagnosis->id,
                    'gejala_id'    => $gejalaId,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ],
                $selectedGejalaIds
            );

            $diagnosis->details()->insert($detailData);

            return $diagnosis->load(['pasien', 'penyakit', 'details.gejala']);
        });
    }

    public function findWithRelations(int $diagnosisId): ?Diagnosis
    {
        return Diagnosis::with(['pasien', 'penyakit', 'details.gejala'])
            ->find($diagnosisId);
    }
}
