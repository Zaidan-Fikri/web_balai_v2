<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiatabsTable extends Migration
{
    public function up()
    {
        Schema::create('siatabs', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('siatabs');
    }
}
