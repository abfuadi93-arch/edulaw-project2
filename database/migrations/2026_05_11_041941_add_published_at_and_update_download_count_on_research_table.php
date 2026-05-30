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
        Schema::table('research', function (Blueprint $table) {
            $table->unsignedBigInteger('download_count')->default(0)->change();
            $table->timestamp('published_at')->nullable()->after('download_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('research', function (Blueprint $table) {
            $table->unsignedInteger('download_count')->default(0)->change();
            $table->dropColumn('published_at');
        });
    }
};
