<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('founders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('role')->default('Co-Founder');
            $table->string('title')->nullable();
            $table->string('affiliation')->nullable();
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->json('expertise')->nullable();
            $table->text('quote')->nullable();
            $table->string('email')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('status')->default('published');
            $table->unsignedInteger('sort_order')->default(1);
            $table->timestamps();
        });

        $founders = [
            [
                'name' => 'Abdul Basid Fuadi',
                'role' => 'Founder',
                'title' => 'Founder Edulaw Project',
                'photo' => 'images/founders/abdul-basid-fuadi.png',
                'bio' => 'Abdul Basid Fuadi menginisiasi Edulaw Project sebagai ruang literasi hukum yang menghubungkan edukasi, riset, advokasi kebijakan publik, dan penguatan komunitas pembelajar hukum.',
                'expertise' => ['Literasi Hukum', 'Kebijakan Publik', 'Ekosistem Pengetahuan'],
                'quote' => 'Edulaw dibangun untuk membuat pengetahuan hukum lebih terbuka, terukur, dan bermanfaat bagi publik.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Azmi Fathu Rohman',
                'role' => 'Co-Founder',
                'title' => 'Co-Founder Edulaw Project',
                'photo' => 'images/founders/azmi-fathu-rohman.png',
                'bio' => 'Azmi Fathu Rohman berkontribusi dalam pengembangan gagasan, komunitas, dan ruang diskusi Edulaw yang berorientasi pada literasi hukum serta pemahaman konstitusional.',
                'expertise' => ['Konstitusi', 'Komunitas', 'Diskusi Publik'],
                'quote' => 'Ruang belajar hukum perlu dibangun secara kolaboratif agar lebih dekat dengan kebutuhan publik.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Faraz Almira Arelia',
                'role' => 'Co-Founder',
                'title' => 'Co-Founder Edulaw Project',
                'photo' => 'images/founders/faraz-almira-arelia.png',
                'bio' => 'Faraz Almira Arelia mendukung penguatan Edulaw sebagai platform edukasi hukum yang inklusif, etis, dan relevan dengan isu sosial serta kebijakan publik.',
                'expertise' => ['Edukasi Hukum', 'Kebijakan Publik', 'Kolaborasi'],
                'quote' => 'Literasi hukum yang baik harus mampu menjangkau lebih banyak orang tanpa kehilangan kualitasnya.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Umi Zakia Azzahro',
                'role' => 'Co-Founder',
                'title' => 'Co-Founder Edulaw Project',
                'photo' => 'images/founders/umi-zakia-azzahro.png',
                'bio' => 'Umi Zakia Azzahro berperan dalam penguatan kerja kolaboratif Edulaw, khususnya pada pengembangan komunitas, publikasi, dan akses pengetahuan hukum.',
                'expertise' => ['Publikasi', 'Komunitas', 'Akses Pengetahuan'],
                'quote' => 'Pengetahuan hukum perlu hadir dalam bahasa yang jernih, bertanggung jawab, dan dapat diakses publik.',
                'sort_order' => 4,
            ],
        ];

        DB::table('founders')->insert(array_map(fn (array $founder): array => [
            ...$founder,
            'slug' => Str::slug($founder['name']),
            'affiliation' => 'Edulaw Project',
            'status' => 'published',
            'expertise' => json_encode($founder['expertise']),
            'created_at' => now(),
            'updated_at' => now(),
        ], $founders));
    }

    public function down(): void
    {
        Schema::dropIfExists('founders');
    }
};
