<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('geolistrik_1ds', function (Blueprint $table) {
            $table->string('kode')->nullable()->after('nama');
            $table->string('kab_kota')->nullable()->after('kode');
            $table->string('kecamatan')->nullable()->after('kab_kota');
            $table->string('desa_kelurahan')->nullable()->after('kecamatan');
            $table->string('upt')->nullable()->after('desa_kelurahan');
            $table->string('elevasi')->nullable()->after('longitude');
            $table->date('tanggal_akusisi_data')->nullable()->after('elevasi');
            $table->text('geologi')->nullable()->after('tanggal_akusisi_data');
            $table->string('cekungan_air_tanah')->nullable()->after('geologi');
            $table->text('hidrogeologi')->nullable()->after('cekungan_air_tanah');
            $table->text('lapisan_pembawa_air')->nullable()->after('hidrogeologi');
        });
    }

    public function down(): void
    {
        Schema::table('geolistrik_1ds', function (Blueprint $table) {
            $table->dropColumn([
                'kode',
                'kab_kota',
                'kecamatan',
                'desa_kelurahan',
                'upt',
                'elevasi',
                'tanggal_akusisi_data',
                'geologi',
                'cekungan_air_tanah',
                'hidrogeologi',
                'lapisan_pembawa_air',
            ]);
        });
    }
};
