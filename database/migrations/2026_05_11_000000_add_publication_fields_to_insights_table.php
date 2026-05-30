<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->string('author')->nullable()->after('content');
            $table->boolean('featured')->default(false)->after('published_at');
        });
    }

    public function down(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->dropColumn(['author', 'featured']);
        });
    }
};
