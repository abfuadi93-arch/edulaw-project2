<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('research', function (Blueprint $table) {
            $table->string('document_type')->default('policy_brief')->after('year');
            $table->string('language')->default('id')->after('document_type');
            $table->string('doi')->nullable()->after('language');
            $table->text('citation')->nullable()->after('doi');
        });
    }

    public function down(): void
    {
        Schema::table('research', function (Blueprint $table) {
            $table->dropColumn(['document_type', 'language', 'doi', 'citation']);
        });
    }
};
