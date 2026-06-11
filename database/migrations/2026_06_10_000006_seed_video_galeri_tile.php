<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('galeri_tiles')->insertOrIgnore([
            'kategori'         => 'Video',
            'image_path'       => null,
            'background_color' => '#061d3f',
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('galeri_tiles')->where('kategori', 'Video')->delete();
    }
};
