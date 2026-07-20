<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GejalaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('gejala')->insert([
            ['kode' => 'G01', 'nama' => 'Gatal pada kulit', 'bobot' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G02', 'nama' => 'Kemerahan pada kulit', 'bobot' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G03', 'nama' => 'Kulit kering dan bersisik', 'bobot' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G04', 'nama' => 'Ruam berair atau melepuh', 'bobot' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G05', 'nama' => 'Pembengkakan pada kulit', 'bobot' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G06', 'nama' => 'Kulit mengelupas', 'bobot' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G07', 'nama' => 'Bintik-bintik merah', 'bobot' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G08', 'nama' => 'Rasa terbakar pada kulit', 'bobot' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G09', 'nama' => 'Kulit menebal', 'bobot' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G10', 'nama' => 'Infeksi atau nanah', 'bobot' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G11', 'nama' => 'Rambut rontok di area kulit', 'bobot' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G12', 'nama' => 'Perubahan warna kulit', 'bobot' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G13', 'nama' => 'Kulit berminyak', 'bobot' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G14', 'nama' => 'Jerawat atau komedo', 'bobot' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'G15', 'nama' => 'Sisik tebal keperakan', 'bobot' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
