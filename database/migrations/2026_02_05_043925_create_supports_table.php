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
        Schema::create('supports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // コメント/スタンプしたユーザー
            $table->foreignId('target_user_id')->constrained('users'); // 応援されるユーザー
            $table->text('comment')->nullable(); // コメント
            $table->string('stamp')->nullable(); // スタンプ（例: '👍', '🎉'）
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supports');
    }
};
