<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $prefix = DB::getTablePrefix();

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        foreach (['Insight', 'Opini', 'Riset'] as $name) {
            DB::table('categories')->insert([
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('insights', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->nullable()
                ->after('category')
                ->constrained()
                ->nullOnDelete();
        });

        DB::table('insights')
            ->leftJoin('categories', 'insights.category', '=', 'categories.name')
            ->whereNull('insights.category_id')
            ->update(['insights.category_id' => DB::raw($prefix.'categories.id')]);
    }

    public function down(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });

        Schema::dropIfExists('categories');
    }
};
