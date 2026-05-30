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
        Schema::table('research', function (Blueprint $table) {
            $table->string('status')->default('published')->after('cover');
            $table->unsignedInteger('download_count')->default(0)->after('status');
        });

        DB::table('research')->update(['status' => 'published']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('research', function (Blueprint $table) {
            $table->dropColumn(['status', 'download_count']);
        });
    }
};
