<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('geolistrik_1ds', function (Blueprint $table) {
            if (Schema::hasColumn('geolistrik_1ds', 'nama')) {
                $table->dropColumn('nama');
            }
        });
    }

    public function down(): void
    {
        Schema::table('geolistrik_1ds', function (Blueprint $table) {
            if (! Schema::hasColumn('geolistrik_1ds', 'nama')) {
                $table->string('nama')->nullable()->after('id');
            }
        });
    }
};
