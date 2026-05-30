<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('insights', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique()->nullable();
        $table->string('category')->nullable();
        $table->text('summary')->nullable();
        
        // Cukup satu saja yang ini:
        $table->longText('content')->nullable(); 
        
        $table->date('published_at')->nullable();
        $table->string('thumbnail')->nullable();
        
        // Kolom 'image' biasanya sama dengan 'thumbnail', 
        // hapus salah satu jika tidak perlu agar tidak bingung.
        $table->string('image')->nullable(); 
        
        $table->boolean('is_visible')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insights');
    }
};
