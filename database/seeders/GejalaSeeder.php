<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GejalaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('gejala')->insert([
            ['kode_gejala' => 'G01', 'nama_gejala' => 'Gatal pada kulit',           'bobot' => 5.00, 'created_at' => now(), 'updated_at' => now()],
            ['kode_gejala' => 'G02', 'nama_gejala' => 'Kemerahan pada kulit',       'bobot' => 4.00, 'created_at' => now(), 'updated_at' => now()],
            ['kode_gejala' => 'G03', 'nama_gejala' => 'Kulit kering dan bersisik',  'bobot' => 4.00, 'created_at' => now(), 'updated_at' => now()],
            ['kode_gejala' => 'G04', 'nama_gejala' => 'Ruam berair atau melepuh',   'bobot' => 5.00, 'created_at' => now(), 'updated_at' => now()],
            ['kode_gejala' => 'G05', 'nama_gejala' => 'Pembengkakan pada kulit',    'bobot' => 3.00, 'created_at' => now(), 'updated_at' => now()],
            ['kode_gejala' => 'G06', 'nama_gejala' => 'Kulit mengelupas',           'bobot' => 3.00, 'created_at' => now(), 'updated_at' => now()],
            ['kode_gejala' => 'G07', 'nama_gejala' => 'Bintik-bintik merah',        'bobot' => 4.00, 'created_at' => now(), 'updated_at' => now()],
            ['kode_gejala' => 'G08', 'nama_gejala' => 'Rasa terbakar pada kulit',   'bobot' => 3.00, 'created_at' => now(), 'updated_at' => now()],
            ['kode_gejala' => 'G09', 'nama_gejala' => 'Kulit menebal',              'bobot' => 3.00, 'created_at' => now(), 'updated_at' => now()],
            ['kode_gejala' => 'G10', 'nama_gejala' => 'Infeksi atau nanah',         'bobot' => 5.00, 'created_at' => now(), 'updated_at' => now()],
            ['kode_gejala' => 'G11', 'nama_gejala' => 'Rambut rontok di area kulit','bobot' => 2.00, 'created_at' => now(), 'updated_at' => now()],
            ['kode_gejala' => 'G12', 'nama_gejala' => 'Perubahan warna kulit',      'bobot' => 2.00, 'created_at' => now(), 'updated_at' => now()],
            ['kode_gejala' => 'G13', 'nama_gejala' => 'Kulit berminyak',            'bobot' => 2.00, 'created_at' => now(), 'updated_at' => now()],
            ['kode_gejala' => 'G14', 'nama_gejala' => 'Jerawat atau komedo',        'bobot' => 3.00, 'created_at' => now(), 'updated_at' => now()],
            ['kode_gejala' => 'G15', 'nama_gejala' => 'Sisik tebal keperakan',      'bobot' => 5.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
