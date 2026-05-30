<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('research', function (Blueprint $table) {
            $table->string('authors')->nullable()->after('title');
            $table->string('category')->nullable()->after('language');
            $table->json('keywords')->nullable()->after('category');
            $table->text('abstract')->nullable()->after('keywords');
            $table->json('key_findings')->nullable()->after('abstract');
            $table->text('preview_note')->nullable()->after('key_findings');
        });
    }

    public function down(): void
    {
        Schema::table('research', function (Blueprint $table) {
            $table->dropColumn([
                'authors',
                'category',
                'keywords',
                'abstract',
                'key_findings',
                'preview_note',
            ]);
        });
    }
};
