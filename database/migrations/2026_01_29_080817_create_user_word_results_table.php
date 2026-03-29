<?php

// database/migrations/xxxx_xx_xx_create_user_word_results_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_word_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('word_id')->constrained()->onDelete('cascade');
            $table->integer('mistake_count')->default(0);
            $table->tinyInteger('rank')->default(3); // 初期は「苦手」
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_word_results');
    }
};

