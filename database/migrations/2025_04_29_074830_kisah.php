<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kisah', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('sinopsis');
            $table->unsignedBigInteger('user_id');
            $table->mediumText('isi');
            $table->integer('like')->default(0);
            $table->integer('dislike')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('genre', function (Blueprint $table) {
            $table->unsignedBigInteger('kisah_id');
            $table->enum('genre', ['Romance', 'Fantasy', 'Horror', 'Misteri', 'Laga', 'Sejarah', 'Fiksi Ilmiah', 'Petualangan']);

            $table->foreign('kisah_id')->references('id')->on('kisah');
        });

        Schema::create('komen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kisah_id');
            $table->unsignedBigInteger('user_id');
            $table->text('isi');
            $table->timestamps();

            $table->foreign('kisah_id')->references('id')->on('kisah');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre');
        Schema::dropIfExists('komen');
        Schema::dropIfExists('kisah');
    }
};
