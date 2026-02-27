<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleToThumbnailsTable extends Migration
{
    public function up()
    {
        Schema::table('thumbnails', function (Blueprint $table) {
            $table->string('title')->nullable()->after('image_path');
        });
    }

    public function down()
    {
        Schema::table('thumbnails', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
}
