<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSiatabImagesTable extends Migration
{
    public function up()
    {
        Schema::create('siatab_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siatab_id')->constrained('siatabs')->cascadeOnDelete();
            $table->string('image_path');
            $table->timestamps();
        });

        $now = now();
        $rows = DB::table('siatabs')
            ->select('id', 'image_path')
            ->whereNotNull('image_path')
            ->where('image_path', '!=', '')
            ->get()
            ->map(function ($row) use ($now) {
                return [
                    'siatab_id' => $row->id,
                    'image_path' => $row->image_path,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })
            ->all();

        if (!empty($rows)) {
            DB::table('siatab_images')->insert($rows);
        }
    }

    public function down()
    {
        Schema::dropIfExists('siatab_images');
    }
}
