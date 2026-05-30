<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->nullable();
            $table->text('content');
            $table->string('avatar')->nullable();
            $table->string('status')->default('draft');
            $table->unsignedInteger('sort_order')->default(1);
            $table->timestamps();
        });

        DB::table('testimonials')->insert([
            [
                'name' => 'Budi Santoso',
                'role' => 'Mahasiswa Hukum UI',
                'content' => 'Platform Edulaw sangat membantu saya memahami hukum acara pidana dengan lebih praktis. Desainnya juga sangat nyaman di mata.',
                'status' => 'published',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Aminah',
                'role' => 'Paralegal',
                'content' => 'Materi advokasinya sangat relevan dengan pekerjaan saya di LBH. Sangat direkomendasikan untuk rekan sejawat!',
                'status' => 'published',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Reza Rahardian',
                'role' => 'Masyarakat Umum',
                'content' => 'Akhirnya ada insight hukum yang tidak kaku. Penjelasannya ringkas tapi mendalam. Suka sekali!',
                'status' => 'published',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
