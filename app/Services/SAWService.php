<?php

namespace App\Services;

use App\Models\Gejala;
use App\Models\NilaiKecocokan;
use App\Models\Penyakit;

class SAWService
{
    /**
     * Jalankan seluruh proses SAW berdasarkan gejala yang dipilih.
     *
     * @param  array<int>  $selectedGejalaIds
     * @return array{ penyakit: Penyakit, nilai_akhir: float, ranking: array }
     */
    public function hitung(array $selectedGejalaIds): array
    {
        $gejalaList  = $this->getSelectedGejala($selectedGejalaIds);
        $penyakitList = $this->getAllPenyakit();

        $decisionMatrix   = $this->buildDecisionMatrix($penyakitList, $gejalaList);
        $normalizedMatrix = $this->normalize($decisionMatrix);
        $preferenceValues = $this->hitungNilaiPreferensi($normalizedMatrix, $gejalaList);
        $ranking          = $this->rank($preferenceValues, $penyakitList);

        $hasilTertinggi = $ranking[0];

        return [
            'penyakit'         => $hasilTertinggi['penyakit'],
            'nilai_preferensi' => $hasilTertinggi['nilai_preferensi'],
            'ranking'          => $ranking,
        ];
    }

    /**
     * Ambil data gejala yang dipilih user beserta bobotnya.
     */
    private function getSelectedGejala(array $selectedGejalaIds): \Illuminate\Support\Collection
    {
        return Gejala::whereIn('id', $selectedGejalaIds)
            ->orderBy('id')
            ->get(['id', 'kode_gejala', 'nama_gejala', 'bobot']);
    }

    /**
     * Ambil seluruh data penyakit beserta nilai kecocokan terhadap gejala terpilih.
     */
    private function getAllPenyakit(): \Illuminate\Support\Collection
    {
        return Penyakit::with('nilaiKecocokan')->orderBy('id')->get();
    }

    /**
     * Bangun matriks keputusan.
     * Baris = Penyakit, Kolom = Gejala terpilih, Nilai = nilai kecocokan (0 jika tidak ada).
     *
     * @return array<int, array<int, float>>  [penyakit_id => [gejala_id => nilai]]
     */
    private function buildDecisionMatrix(
        \Illuminate\Support\Collection $penyakitList,
        \Illuminate\Support\Collection $gejalaList
    ): array {
        $matrix = [];

        foreach ($penyakitList as $penyakit) {
            $row = [];

            foreach ($gejalaList as $gejala) {
                $nilaiKecocokan = $penyakit->nilaiKecocokan
                    ->firstWhere('gejala_id', $gejala->id);

                $row[$gejala->id] = $nilaiKecocokan ? (float) $nilaiKecocokan->nilai : 0.0;
            }

            $matrix[$penyakit->id] = $row;
        }

        return $matrix;
    }

    /**
     * Normalisasi matriks keputusan.
     * Setiap nilai dibagi dengan nilai maksimum pada kolomnya.
     *
     * @param  array<int, array<int, float>>  $matrix
     * @return array<int, array<int, float>>
     */
    private function normalize(array $matrix): array
    {
        if (empty($matrix)) {
            return [];
        }

        // Kumpulkan nilai max untuk setiap kolom (gejala)
        $columnMax = [];
        foreach ($matrix as $row) {
            foreach ($row as $gejalaId => $nilai) {
                if (! isset($columnMax[$gejalaId]) || $nilai > $columnMax[$gejalaId]) {
                    $columnMax[$gejalaId] = $nilai;
                }
            }
        }

        // Normalisasi: nilai / max kolom (jika max = 0, hasil = 0)
        $normalized = [];
        foreach ($matrix as $penyakitId => $row) {
            foreach ($row as $gejalaId => $nilai) {
                $max = $columnMax[$gejalaId] ?? 0;
                $normalized[$penyakitId][$gejalaId] = $max > 0
                    ? round($nilai / $max, 4)
                    : 0.0;
            }
        }

        return $normalized;
    }

    /**
     * Hitung nilai preferensi setiap penyakit.
     * Nilai preferensi = sum(normalisasi × bobot gejala)
     *
     * @param  array<int, array<int, float>>  $normalizedMatrix
     * @return array<int, float>  [penyakit_id => nilai_preferensi]
     */
    private function hitungNilaiPreferensi(
        array $normalizedMatrix,
        \Illuminate\Support\Collection $gejalaList
    ): array {
        $preferenceValues = [];

        foreach ($normalizedMatrix as $penyakitId => $row) {
            $nilaiPreferensi = 0.0;

            foreach ($gejalaList as $gejala) {
                $nilaiNormalisasi = $row[$gejala->id] ?? 0.0;
                $nilaiPreferensi += $nilaiNormalisasi * (float) $gejala->bobot;
            }

            $preferenceValues[$penyakitId] = round($nilaiPreferensi, 4);
        }

        return $preferenceValues;
    }

    /**
     * Urutkan penyakit berdasarkan nilai preferensi (tertinggi ke terendah).
     *
     * @param  array<int, float>  $preferenceValues
     * @return array<int, array{ penyakit: Penyakit, nilai_preferensi: float }>
     */
    private function rank(
        array $preferenceValues,
        \Illuminate\Support\Collection $penyakitList
    ): array {
        $ranking = [];

        foreach ($penyakitList as $penyakit) {
            $ranking[] = [
                'penyakit'        => $penyakit,
                'nilai_preferensi' => $preferenceValues[$penyakit->id] ?? 0.0,
            ];
        }

        usort($ranking, fn ($a, $b) => $b['nilai_preferensi'] <=> $a['nilai_preferensi']);

        return $ranking;
    }
}
