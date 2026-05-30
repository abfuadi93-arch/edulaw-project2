<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->string('author_name')->nullable()->after('author_id');
            $table->string('author_affiliation')->nullable()->after('author_name');
            $table->string('author_photo')->nullable()->after('author_affiliation');
        });

        DB::table('insights')
            ->leftJoin('users', 'insights.author_id', '=', 'users.id')
            ->whereNull('insights.author_name')
            ->update(['insights.author_name' => DB::raw('coalesce(users.name, insights.author)')]);
    }

    public function down(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->dropColumn(['author_name', 'author_affiliation', 'author_photo']);
        });
    }
};
