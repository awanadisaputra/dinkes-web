<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->enum('status', ['published', 'draft'])->default('published')->after('content');
        });

        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('pending', 'published', 'rejected', 'draft') DEFAULT 'published'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('pending', 'published', 'rejected') DEFAULT 'published'");
    }
};
