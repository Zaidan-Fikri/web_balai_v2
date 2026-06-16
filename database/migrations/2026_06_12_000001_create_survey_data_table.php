<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_data', function (Blueprint $table) {
            $table->id();
            $table->string('type', 30)->index(); // geolistrik_2d | pumping_test | borehole_camera | logging
            $table->string('kode');
            $table->string('kab_kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('upt')->nullable()->index();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('elevasi')->nullable();
            $table->date('tanggal_akusisi_data')->nullable();
            $table->text('geologi')->nullable();
            $table->string('cekungan_air_tanah')->nullable();
            $table->text('hidrogeologi')->nullable();
            $table->text('lapisan_pembawa_air')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamps();

            $table->index(['type', 'upt']);
            $table->index(['type', 'kode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_data');
    }
};
