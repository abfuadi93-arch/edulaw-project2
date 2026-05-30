<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->string('label')->nullable()->after('title');
            $table->json('highlights')->nullable()->after('description');
            $table->unsignedInteger('sort_order')->default(0)->after('image');
        });

        $programs = [
            [
                'title' => 'Kelas Tematik',
                'label' => 'Batch',
                'description' => 'Struktur belajar terarah dengan materi hukum yang dikurasi.',
                'highlights' => [
                    'Silabus ringkas dan target kompetensi jelas',
                    'Materi berbasis undang-undang, putusan, dan kebijakan aktual',
                    'Catatan belajar, studi kasus, dan latihan singkat',
                ],
                'sort_order' => 1,
            ],
            [
                'title' => 'Diskusi & Workshop',
                'label' => 'Live',
                'description' => 'Forum interaktif untuk membahas isu hukum dan kebijakan publik.',
                'highlights' => [
                    'Bedah isu regulasi, putusan, dan kebijakan terbaru',
                    'Format dialog, tanya-jawab, studi kasus, dan refleksi',
                    'Ringkasan hasil diskusi untuk peserta',
                ],
                'sort_order' => 2,
            ],
            [
                'title' => 'Konten Digital',
                'label' => 'On Demand',
                'description' => 'Materi edukatif singkat untuk belajar hukum secara fleksibel.',
                'highlights' => [
                    'Video pendek, infografik, dan bahan bacaan',
                    'Cocok untuk pengantar isu hukum dan konstitusi',
                    'Dapat diakses sesuai kebutuhan belajar',
                ],
                'sort_order' => 3,
            ],
            [
                'title' => 'Riset & Policy Brief',
                'label' => 'Project Based',
                'description' => 'Pendampingan penyusunan riset hukum dan rekomendasi kebijakan.',
                'highlights' => [
                    'Penyusunan legal memo, policy brief, dan riset tematik',
                    'Berbasis data, regulasi, dan putusan',
                    'Output dapat digunakan untuk advokasi kebijakan',
                ],
                'sort_order' => 4,
            ],
        ];

        foreach ($programs as $program) {
            DB::table('programs')->updateOrInsert(
                ['title' => $program['title']],
                [
                    'label' => $program['label'],
                    'description' => $program['description'],
                    'highlights' => json_encode($program['highlights']),
                    'sort_order' => $program['sort_order'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn(['label', 'highlights', 'sort_order']);
        });
    }
};
