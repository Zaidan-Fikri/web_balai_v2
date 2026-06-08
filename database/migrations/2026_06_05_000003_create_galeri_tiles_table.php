<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galeri_tiles', function (Blueprint $table) {
            $table->id();
            $table->string('kategori')->unique();
            $table->string('image_path')->nullable();
            $table->string('background_color', 7)->nullable();
            $table->timestamps();
        });

        DB::table('galeri_tiles')->insert([
            ['kategori' => 'Geolistrik 1D',   'image_path' => null, 'background_color' => '#0d2d5e', 'created_at' => now(), 'updated_at' => now()],
            ['kategori' => 'Geolistrik 2D',   'image_path' => null, 'background_color' => '#0d2d5e', 'created_at' => now(), 'updated_at' => now()],
            ['kategori' => 'Pumping Test',    'image_path' => null, 'background_color' => '#0d2d5e', 'created_at' => now(), 'updated_at' => now()],
            ['kategori' => 'Borehole Camera', 'image_path' => null, 'background_color' => '#0d2d5e', 'created_at' => now(), 'updated_at' => now()],
            ['kategori' => 'Logger',          'image_path' => null, 'background_color' => '#0d2d5e', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri_tiles');
    }
};
