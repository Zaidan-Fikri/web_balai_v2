<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThumbnailPathToKaryaIlmiahsTable extends Migration
{
    public function up()
    {
        Schema::table('karya_ilmiahs', function (Blueprint $table) {
            $table->string('thumbnail_path')->nullable()->after('deskripsi');
        });
    }

    public function down()
    {
        Schema::table('karya_ilmiahs', function (Blueprint $table) {
            $table->dropColumn('thumbnail_path');
        });
    }
}
