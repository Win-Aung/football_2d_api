<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('twod_bets', function (Blueprint $table) {
            $table->id();
            $table->integer('userId');
            $table->string('userName', 100);
            $table->string('phone', 20);
            $table->string('session', 20);
            $table->text('bets');
            $table->decimal('total_amount', 10, 2);
            $table->string('number', 10);
            $table->decimal('amount', 15, 2);
            $table->timestamp('time')->useCurrent();
            $table->boolean('isArchived')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('twod_bets');
    }
};