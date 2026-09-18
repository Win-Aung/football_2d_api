<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('game_bets', function (Blueprint $table) {
            $table->id();
            $table->integer('userId');
            $table->string('userName', 100);
            $table->text('bets_json');
            $table->decimal('total_amount', 10, 2);
            $table->string('animal', 50);
            $table->decimal('amount', 15, 2);
            $table->string('status', 20)->nullable()->default('Pending');
            $table->decimal('winAmount', 15, 2)->nullable()->default(0.00);
            $table->string('luckyAnimal', 50)->nullable()->default('');
            $table->timestamp('time')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_bets');
    }
};