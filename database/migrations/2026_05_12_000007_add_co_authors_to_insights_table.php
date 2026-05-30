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
        Schema::table('insights', function (Blueprint $table) {
            $table->json('co_authors')->nullable()->after('author_photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->dropColumn('co_authors');
        });
    }
};
