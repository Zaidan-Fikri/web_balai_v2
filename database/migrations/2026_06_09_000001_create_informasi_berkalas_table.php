<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasi_berkalas', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['laporan_ppid', 'survey_kepuasan', 'maklumat_pelayanan', 'standar_pelayanan']);
            $table->unsignedSmallInteger('tahun');
            $table->string('judul');
            $table->string('pdf_path');
            $table->unsignedTinyInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_berkalas');
    }
};
