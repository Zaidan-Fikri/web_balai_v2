<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();
        DB::table('profile_pages')->insert([
            ['title' => 'Tentang Kami', 'slug' => 'tentang-kami', 'content' => null, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Tugas dan Fungsi', 'slug' => 'tugas-dan-fungsi', 'content' => null, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Visi dan Misi', 'slug' => 'visi-dan-misi', 'content' => null, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Struktur Organisasi', 'slug' => 'struktur-organisasi', 'content' => null, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Informasi Pejabat', 'slug' => 'informasi-pejabat', 'content' => null, 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Zona Integritas', 'slug' => 'zona-integritas', 'content' => null, 'sort_order' => 6, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Lokasi dan Kontak', 'slug' => 'lokasi-dan-kontak', 'content' => null, 'sort_order' => 7, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_pages');
    }
};
