<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiKecocokanSeeder extends Seeder
{
    public function run(): void
    {
        // Mapping: penyakit_id => [gejala_id => nilai]
        // Gejala:
        // G01=1 Gatal, G02=2 Kemerahan, G03=3 Kering/Bersisik, G04=4 Ruam berair/melepuh
        // G05=5 Pembengkakan, G06=6 Mengelupas, G07=7 Bintik merah, G08=8 Terbakar
        // G09=9 Menebal, G10=10 Infeksi/Nanah, G11=11 Rambut rontok, G12=12 Perubahan warna
        // G13=13 Berminyak, G14=14 Jerawat/Komedo, G15=15 Sisik keperakan

        $data = [
            // P01 - Dermatitis Atopik
            [1, 1, 5], [1, 2, 4], [1, 3, 5], [1, 4, 3], [1, 5, 2],
            [1, 6, 3], [1, 7, 2], [1, 8, 3], [1, 9, 2], [1, 10, 1],
            [1, 11, 1], [1, 12, 2], [1, 13, 1], [1, 14, 1], [1, 15, 1],

            // P02 - Psoriasis
            [2, 1, 4], [2, 2, 5], [2, 3, 4], [2, 4, 1], [2, 5, 2],
            [2, 6, 3], [2, 7, 3], [2, 8, 2], [2, 9, 5], [2, 10, 1],
            [2, 11, 2], [2, 12, 3], [2, 13, 1], [2, 14, 1], [2, 15, 5],

            // P03 - Dermatitis Kontak
            [3, 1, 5], [3, 2, 5], [3, 3, 3], [3, 4, 4], [3, 5, 4],
            [3, 6, 2], [3, 7, 4], [3, 8, 5], [3, 9, 1], [3, 10, 2],
            [3, 11, 1], [3, 12, 2], [3, 13, 1], [3, 14, 1], [3, 15, 1],

            // P04 - Tinea Pedis
            [4, 1, 4], [4, 2, 2], [4, 3, 4], [4, 4, 2], [4, 5, 1],
            [4, 6, 5], [4, 7, 2], [4, 8, 4], [4, 9, 2], [4, 10, 3],
            [4, 11, 2], [4, 12, 2], [4, 13, 1], [4, 14, 1], [4, 15, 1],

            // P05 - Urtikaria
            [5, 1, 5], [5, 2, 5], [5, 3, 1], [5, 4, 2], [5, 5, 5],
            [5, 6, 1], [5, 7, 5], [5, 8, 3], [5, 9, 1], [5, 10, 1],
            [5, 11, 1], [5, 12, 2], [5, 13, 1], [5, 14, 1], [5, 15, 1],

            // P06 - Acne Vulgaris
            [6, 1, 2], [6, 2, 3], [6, 3, 1], [6, 4, 2], [6, 5, 2],
            [6, 6, 2], [6, 7, 3], [6, 8, 2], [6, 9, 1], [6, 10, 4],
            [6, 11, 1], [6, 12, 2], [6, 13, 5], [6, 14, 5], [6, 15, 1],
        ];

        $records = array_map(fn ($row) => [
            'penyakit_id' => $row[0],
            'gejala_id' => $row[1],
            'nilai' => $row[2],
            'created_at' => now(),
            'updated_at' => now(),
        ], $data);

        DB::table('nilai_kecocokan')->insert($records);
    }
}
