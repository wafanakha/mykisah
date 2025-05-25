<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kisah_user_reactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kisah_id')->constrained('kisah')->onDelete('cascade');

            $table->tinyInteger('value'); // 1 for like, -1 for dislike

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kisah_user_reactions');
    }
};
