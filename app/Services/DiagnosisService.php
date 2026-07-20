<?php

namespace App\Services;

use App\Models\Diagnosis;
use App\Models\Gejala;
use App\Models\Penyakit;
use Illuminate\Support\Facades\DB;

class DiagnosisService
{
    public function __construct(
        protected SAWService $sawService
    ) {}

    /**
     * Ambil semua gejala untuk form diagnosis.
     */
    public function getAllGejala()
    {
        return Gejala::orderBy('kode')->get(['id', 'kode', 'nama', 'bobot']);
    }

    /**
     * Jalankan proses diagnosis dan simpan hasilnya dalam satu transaksi.
     *
     * @param  array  $pasienData  [nama_pasien, usia, jenis_kelamin]
     * @param  array<int>  $selectedGejalaIds
     * @param  int  $userId
     * @return Diagnosis
     */
    public function proses(array $pasienData, array $selectedGejalaIds, int $userId): Diagnosis
    {
        return DB::transaction(function () use ($pasienData, $selectedGejalaIds, $userId) {
            // Hitung SAW
            $hasilSAW = $this->sawService->hitung($selectedGejalaIds);

            /** @var Penyakit $penyakitTerpilih */
            $penyakitTerpilih = $hasilSAW['penyakit'];
            $nilaiAkhir       = $hasilSAW['nilai_akhir'];

            // Simpan diagnosis
            $diagnosis = Diagnosis::create([
                'nama_pasien'  => $pasienData['nama_pasien'],
                'usia'         => $pasienData['usia'],
                'jenis_kelamin' => $pasienData['jenis_kelamin'],
                'user_id'      => $userId,
                'penyakit_id'  => $penyakitTerpilih->id,
                'nilai_akhir'  => $nilaiAkhir,
            ]);

            // Simpan detail diagnosis (gejala yang dipilih)
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

            return $diagnosis->load(['penyakit', 'details.gejala']);
        });
    }

    /**
     * Ambil hasil SAW untuk ditampilkan tanpa menyimpan (preview).
     *
     * @param  array<int>  $selectedGejalaIds
     */
    public function preview(array $selectedGejalaIds): array
    {
        return $this->sawService->hitung($selectedGejalaIds);
    }

    /**
     * Ambil data diagnosis beserta relasi untuk halaman hasil.
     */
    public function findWithRelations(int $diagnosisId): ?Diagnosis
    {
        return Diagnosis::with(['penyakit', 'details.gejala', 'user'])
            ->find($diagnosisId);
    }
}
