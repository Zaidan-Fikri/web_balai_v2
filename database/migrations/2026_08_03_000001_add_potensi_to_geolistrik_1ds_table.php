<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('geolistrik_1ds', function (Blueprint $table) {
            $table->text('potensi')->nullable()->after('lapisan_pembawa_air');
        });
    }

    public function down(): void
    {
        Schema::table('geolistrik_1ds', function (Blueprint $table) {
            $table->dropColumn('potensi');
        });
    }
};
