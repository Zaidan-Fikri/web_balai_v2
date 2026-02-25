<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowOnHomeToThumbnailsTable extends Migration
{
    public function up()
    {
        Schema::table('thumbnails', function (Blueprint $table) {
            $table->boolean('show_on_home')->default(false)->after('image_path');
        });
    }

    public function down()
    {
        Schema::table('thumbnails', function (Blueprint $table) {
            $table->dropColumn('show_on_home');
        });
    }
}
