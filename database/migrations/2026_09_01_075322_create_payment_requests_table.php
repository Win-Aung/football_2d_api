<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('userId');
            $table->string('userName', 100);
            $table->string('phone', 20);
            $table->string('payment', 50);
            $table->string('type', 20);
            $table->decimal('amount', 15, 2);
            $table->string('transactionId', 100)->nullable()->default('');
            $table->string('status', 20)->nullable()->default('Pending');
            $table->timestamp('time')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
    }
};