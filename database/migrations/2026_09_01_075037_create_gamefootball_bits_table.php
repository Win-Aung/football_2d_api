<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gamefootball_bits', function (Blueprint $table) {
            $table->id();
            $table->string('user_doc_id', 255);
            $table->string('bet_type', 50);
            $table->string('match_id', 50);
            $table->string('home_team', 100);
            $table->string('goal_total', 50)->nullable();
            $table->string('away_team', 100);
            $table->text('selected_option');
            $table->decimal('amount', 10, 2);
            $table->decimal('win_amount', 10, 2)->default(0.00);
            $table->decimal('lost', 10, 2)->default(0.00);
            $table->string('status', 20)->default('pending');
            $table->dateTime('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gamefootball_bits');
    }
};