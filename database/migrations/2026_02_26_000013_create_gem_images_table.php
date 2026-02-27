<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGemImagesTable extends Migration
{
    public function up()
    {
        Schema::create('gem_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gem_id')->constrained('gems')->cascadeOnDelete();
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gem_images');
    }
}
