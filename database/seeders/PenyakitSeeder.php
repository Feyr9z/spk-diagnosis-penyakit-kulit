<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenyakitSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('penyakit')->insert([
            [
                'kode_penyakit' => 'P01',
                'nama_penyakit' => 'Dermatitis Atopik',
                'deskripsi' => 'Dermatitis atopik adalah peradangan kulit kronis yang menyebabkan kulit menjadi gatal, merah, dan kering. Kondisi ini sering disebut juga eksim dan umumnya dimulai sejak masa kanak-kanak.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_penyakit' => 'P02',
                'nama_penyakit' => 'Psoriasis',
                'deskripsi' => 'Psoriasis adalah penyakit autoimun yang menyebabkan siklus pertumbuhan sel kulit yang terlalu cepat, sehingga menghasilkan bercak tebal, kemerahan, dan bersisik pada permukaan kulit.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_penyakit' => 'P03',
                'nama_penyakit' => 'Dermatitis Kontak',
                'deskripsi' => 'Dermatitis kontak adalah reaksi peradangan kulit yang terjadi akibat kontak langsung dengan zat iritan atau alergen, seperti bahan kimia, logam, atau tanaman tertentu.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_penyakit' => 'P04',
                'nama_penyakit' => 'Tinea Pedis (Kutu Air)',
                'deskripsi' => 'Tinea pedis adalah infeksi jamur pada kaki yang menyebabkan kulit mengelupas, gatal, dan terkadang terasa terbakar, terutama di antara jari-jari kaki.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_penyakit' => 'P05',
                'nama_penyakit' => 'Urtikaria (Biduran)',
                'deskripsi' => 'Urtikaria atau biduran adalah reaksi alergi pada kulit yang ditandai dengan munculnya bentol-bentol merah yang gatal dan dapat berpindah-pindah tempat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_penyakit' => 'P06',
                'nama_penyakit' => 'Acne Vulgaris (Jerawat)',
                'deskripsi' => 'Acne vulgaris atau jerawat adalah kondisi kulit yang terjadi ketika folikel rambut tersumbat oleh minyak dan sel kulit mati, menyebabkan munculnya komedo, papul, pustul, atau kista.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
