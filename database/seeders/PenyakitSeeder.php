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
                'kode'      => 'P01',
                'nama'      => 'Dermatitis Atopik',
                'deskripsi' => 'Dermatitis atopik adalah peradangan kulit kronis yang menyebabkan kulit menjadi gatal, merah, dan kering. Kondisi ini sering disebut juga eksim dan umumnya dimulai sejak masa kanak-kanak.',
                'solusi'    => 'Gunakan pelembap secara rutin, hindari sabun atau detergen keras, gunakan pakaian berbahan katun, dan konsultasikan dengan dokter kulit untuk mendapatkan krim kortikosteroid jika diperlukan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode'      => 'P02',
                'nama'      => 'Psoriasis',
                'deskripsi' => 'Psoriasis adalah penyakit autoimun yang menyebabkan siklus pertumbuhan sel kulit yang terlalu cepat, sehingga menghasilkan bercak tebal, kemerahan, dan bersisik pada permukaan kulit.',
                'solusi'    => 'Gunakan krim pelembap, hindari pemicu stres, lakukan fototerapi sesuai anjuran dokter, dan gunakan obat topikal seperti kortikosteroid atau vitamin D analog yang diresepkan dokter.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode'      => 'P03',
                'nama'      => 'Dermatitis Kontak',
                'deskripsi' => 'Dermatitis kontak adalah reaksi peradangan kulit yang terjadi akibat kontak langsung dengan zat iritan atau alergen, seperti bahan kimia, logam, atau tanaman tertentu.',
                'solusi'    => 'Identifikasi dan hindari zat penyebab reaksi, cuci area yang terkena dengan air bersih segera setelah kontak, gunakan krim kortikosteroid topikal, dan konsultasikan dengan dokter untuk penanganan lanjut.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode'      => 'P04',
                'nama'      => 'Tinea Pedis (Kutu Air)',
                'deskripsi' => 'Tinea pedis adalah infeksi jamur pada kaki yang menyebabkan kulit mengelupas, gatal, dan terkadang terasa terbakar, terutama di antara jari-jari kaki.',
                'solusi'    => 'Jaga kaki tetap bersih dan kering, gunakan kaus kaki berbahan katun, hindari berjalan tanpa alas kaki di tempat umum, dan gunakan obat antijamur topikal sesuai anjuran dokter.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode'      => 'P05',
                'nama'      => 'Urtikaria (Biduran)',
                'deskripsi' => 'Urtikaria atau biduran adalah reaksi alergi pada kulit yang ditandai dengan munculnya bentol-bentol merah yang gatal dan dapat berpindah-pindah tempat.',
                'solusi'    => 'Hindari pemicu alergi yang diketahui, konsumsi antihistamin sesuai anjuran dokter, hindari makanan atau obat-obatan penyebab reaksi, dan segera konsultasikan ke dokter jika gejala tidak membaik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode'      => 'P06',
                'nama'      => 'Acne Vulgaris (Jerawat)',
                'deskripsi' => 'Acne vulgaris atau jerawat adalah kondisi kulit yang terjadi ketika folikel rambut tersumbat oleh minyak dan sel kulit mati, menyebabkan munculnya komedo, papul, pustul, atau kista.',
                'solusi'    => 'Cuci wajah dua kali sehari dengan sabun lembut, hindari memencet jerawat, gunakan produk skincare non-komedogenik, dan konsultasikan dengan dokter untuk obat topikal atau oral jika jerawat parah.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
