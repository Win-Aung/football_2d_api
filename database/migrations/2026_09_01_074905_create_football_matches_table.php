<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('football_matches', function (Blueprint $table) {
            $table->id();
            $table->string('league_name', 255)->nullable();
            $table->string('home_team', 100);
            $table->string('away_team', 100);
            $table->string('home_odds', 50)->nullable();
            $table->string('away_odds', 50)->nullable();
            $table->string('goal_total', 50)->nullable();
            $table->string('body_odds', 50)->nullable();
            $table->string('body_away_odds', 255)->nullable();
            $table->string('body_goal_total', 255)->nullable();
            $table->text('video_link')->nullable();
            $table->dateTime('close_time');
            $table->integer('body_status')->default(1);
            $table->integer('maung_status')->default(1);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('football_matches');
    }
};