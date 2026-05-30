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
            $table->string('program_family')->nullable()->after('label');
        });

        DB::table('programs')->update([
            'program_family' => DB::raw("
                CASE
                    WHEN program_type IN ('Inspiring Lecture', 'Public Lecture', 'Keynote Forum', 'Launching Forum')
                        OR title LIKE '%Lecture%' THEN 'Lecturer'
                    WHEN program_type IN ('Diskusi Diseminasi Disertasi', 'Diskusi Diseminasi Tesis', 'Diskusi Literasi Konstitusi', 'Diskusi Respons Isu', 'Bedah Buku Hukum', 'Ngabuburit Virtual')
                        OR title LIKE '%Diskusi%' THEN 'Discussion'
                    WHEN program_type IN ('Kelas Tematik', 'Workshop', 'Klinik Akademik', 'Pelatihan Riset', 'Pelatihan Penulisan Hukum')
                        OR title LIKE '%Kelas%'
                        OR title LIKE '%Training%'
                        OR title LIKE '%Workshop%' THEN 'Training'
                    ELSE 'Discussion'
                END
            "),
        ]);
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('program_family');
        });
    }
};
