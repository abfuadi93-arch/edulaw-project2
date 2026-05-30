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
            $table->string('status')->default('draft')->after('category');
            $table->text('excerpt')->nullable()->after('status');
            $table->dateTime('published_at')->nullable()->change();
        });

        DB::table('insights')->update([
            'status' => DB::raw("case when is_visible = 1 then 'published' else 'draft' end"),
            'excerpt' => DB::raw('summary'),
        ]);
    }

    public function down(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->date('published_at')->nullable()->change();
            $table->dropColumn(['status', 'excerpt']);
        });
    }
};
