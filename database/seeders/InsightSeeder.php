<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Jangan lupa import ini

class InsightSeeder extends Seeder
{
    public function run(): void
    {
        // Data 1
        DB::table('insights')->insert([
            'title' => 'Membaca Putusan, Menimbang Dampak',
            'category' => 'Insight',
            'summary' => 'Ringkasan singkat pada paragraf pembuka yang memberi konteks tanpa harus menghabiskan banyak waktu pembaca.',
            'published_at' => '2025-12-12',
            'image' => null, // Nanti bisa diisi path gambar
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Data 2
        DB::table('insights')->insert([
            'title' => 'Reformasi Birokrasi Konstitusi',
            'category' => 'Insight',
            'summary' => 'Analisis mendalam mengenai tantangan struktural dalam penerapan pasal-pasal karet di birokrasi daerah.',
            'published_at' => '2025-12-10',
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Data 3
        DB::table('insights')->insert([
            'title' => 'Etika Profesi: Batas Moral',
            'category' => 'Insight',
            'summary' => 'Mengapa integritas advokat menjadi kunci utama dalam menjaga kepercayaan publik terhadap sistem peradilan.',
            'published_at' => '2025-12-08',
            'image' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}