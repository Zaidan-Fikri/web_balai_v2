<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buletins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_user_id')
                ->nullable()
                ->constrained('admin_users')
                ->nullOnDelete();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('isi');
            $table->string('status', 20)->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buletins');
    }
};
