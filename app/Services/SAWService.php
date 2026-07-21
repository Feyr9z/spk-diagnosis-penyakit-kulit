<?php

namespace App\Services;

use App\Models\Gejala;
use App\Models\Penyakit;
use Illuminate\Support\Collection;

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
        $gejalaList = $this->getSelectedGejala($selectedGejalaIds);
        $penyakitList = $this->getAllPenyakit();

        $decisionMatrix = $this->buildDecisionMatrix($penyakitList, $gejalaList);
        $normalizedMatrix = $this->normalize($decisionMatrix, $gejalaList);
        $preferenceValues = $this->hitungNilaiPreferensi($normalizedMatrix, $gejalaList);
        $ranking = $this->rank($preferenceValues, $penyakitList);

        $hasilTertinggi = $ranking[0] ?? null;

        return [
            'penyakit' => $hasilTertinggi ? $hasilTertinggi['penyakit'] : null,
            'nilai_preferensi' => $hasilTertinggi ? $hasilTertinggi['nilai_preferensi'] : 0,
            'ranking' => $ranking,
            'decision_matrix' => $decisionMatrix,
            'normalized_matrix' => $normalizedMatrix,
            'gejala_list' => $gejalaList,
            'penyakit_list' => $penyakitList,
        ];
    }

    /**
     * Ambil data gejala yang dipilih user beserta bobotnya.
     */
    private function getSelectedGejala(array $selectedGejalaIds): Collection
    {
        return Gejala::whereIn('id', $selectedGejalaIds)
            ->orderBy('id')
            ->get(['id', 'kode_gejala', 'nama_gejala', 'bobot', 'jenis']);
    }

    /**
     * Ambil seluruh data penyakit beserta nilai kecocokan terhadap gejala terpilih.
     */
    private function getAllPenyakit(): Collection
    {
        return Penyakit::with('nilaiKecocokan')->orderBy('id')->get();
    }

    /**
     * Bangun matriks keputusan.
     * Baris = Penyakit, Kolom = Gejala terpilih, Nilai = nilai kecocokan (0 jika tidak ada).
     *
     * @return array<int, array<int, float>> [penyakit_id => [gejala_id => nilai]]
     */
    private function buildDecisionMatrix(
        Collection $penyakitList,
        Collection $gejalaList
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
     * Benefit = nilai / max. Cost = min / nilai.
     *
     * @param  array<int, array<int, float>>  $matrix
     * @return array<int, array<int, float>>
     */
    private function normalize(array $matrix, Collection $gejalaList): array
    {
        if (empty($matrix)) {
            return [];
        }

        // Kumpulkan nilai max dan min untuk setiap kolom (gejala)
        $columnStats = [];
        foreach ($matrix as $row) {
            foreach ($row as $gejalaId => $nilai) {
                if (! isset($columnStats[$gejalaId])) {
                    $columnStats[$gejalaId] = ['max' => $nilai, 'min' => $nilai];
                } else {
                    if ($nilai > $columnStats[$gejalaId]['max']) {
                        $columnStats[$gejalaId]['max'] = $nilai;
                    }
                    if ($nilai < $columnStats[$gejalaId]['min']) {
                        $columnStats[$gejalaId]['min'] = $nilai;
                    }
                }
            }
        }

        // Normalisasi
        $normalized = [];
        foreach ($matrix as $penyakitId => $row) {
            foreach ($row as $gejalaId => $nilai) {
                $gejala = $gejalaList->firstWhere('id', $gejalaId);
                $isCost = $gejala && $gejala->jenis === 'cost';

                $max = $columnStats[$gejalaId]['max'] ?? 0;
                $min = $columnStats[$gejalaId]['min'] ?? 0;

                if ($isCost) {
                    $normalized[$penyakitId][$gejalaId] = $nilai > 0 ? round($min / $nilai, 4) : 0.0;
                } else {
                    $normalized[$penyakitId][$gejalaId] = $max > 0 ? round($nilai / $max, 4) : 0.0;
                }
            }
        }

        return $normalized;
    }

    /**
     * Hitung nilai preferensi setiap penyakit.
     * Nilai preferensi = sum(normalisasi × bobot gejala)
     *
     * @param  array<int, array<int, float>>  $normalizedMatrix
     * @return array<int, float> [penyakit_id => nilai_preferensi]
     */
    private function hitungNilaiPreferensi(
        array $normalizedMatrix,
        Collection $gejalaList
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
        Collection $penyakitList
    ): array {
        $ranking = [];

        foreach ($penyakitList as $penyakit) {
            $ranking[] = [
                'penyakit' => $penyakit,
                'nilai_preferensi' => $preferenceValues[$penyakit->id] ?? 0.0,
            ];
        }

        usort($ranking, fn ($a, $b) => $b['nilai_preferensi'] <=> $a['nilai_preferensi']);

        return $ranking;
    }
}
