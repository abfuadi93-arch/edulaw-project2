<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insight_topics', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        foreach ([
            'Konstitusi',
            'Demokrasi',
            'Pemilu',
            'HAM',
            'Hukum Digital',
            'Kebijakan Publik',
            'Lingkungan',
            'Peradilan',
            'Antikorupsi',
            'Pendidikan Hukum',
        ] as $name) {
            DB::table('insight_topics')->insert([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('insight_topics');
    }
};
