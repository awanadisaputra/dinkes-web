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
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
            $table->longText('content')->nullable()->after('caption');
        });

        // Populate slug for existing records
        $sliders = \Illuminate\Support\Facades\DB::table('sliders')->get();
        foreach ($sliders as $slider) {
            \Illuminate\Support\Facades\DB::table('sliders')
                ->where('id', $slider->id)
                ->update(['slug' => \Illuminate\Support\Str::slug($slider->title) . '-' . $slider->id]);
        }

        Schema::table('sliders', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['slug', 'content']);
        });
    }
};
