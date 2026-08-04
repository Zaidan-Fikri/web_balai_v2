<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buletins', function (Blueprint $table) {
            $table->foreignId('kategori_edukasi_id')
                ->nullable()
                ->after('admin_user_id')
                ->constrained('kategori_edukasis')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('buletins', function (Blueprint $table) {
            $table->dropConstrainedForeignId('kategori_edukasi_id');
        });
    }
};
