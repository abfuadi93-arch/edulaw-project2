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
        Schema::table('insights', function (Blueprint $table) {
            $table->foreignId('author_id')
                ->nullable()
                ->after('user_id')
                ->constrained('users')
                ->nullOnDelete();
        });

        DB::table('insights')
            ->whereNull('author_id')
            ->update(['author_id' => DB::raw('user_id')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->dropConstrainedForeignId('author_id');
        });
    }
};
