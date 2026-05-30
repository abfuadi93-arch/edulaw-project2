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
        $prefix = DB::getTablePrefix();

        DB::table('insights')
            ->leftJoin('categories', 'insights.category', '=', 'categories.name')
            ->whereNull('insights.category_id')
            ->whereNotNull('insights.category')
            ->update(['insights.category_id' => DB::raw($prefix.'categories.id')]);

        Schema::table('insights', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $prefix = DB::getTablePrefix();

        Schema::table('insights', function (Blueprint $table) {
            $table->string('category')->nullable()->after('meta_description');
        });

        DB::table('insights')
            ->leftJoin('categories', 'insights.category_id', '=', 'categories.id')
            ->whereNotNull('insights.category_id')
            ->update(['insights.category' => DB::raw($prefix.'categories.name')]);
    }
};
