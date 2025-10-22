<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->enum('status',['tentative','awaiting_payment','confirmed','cancelled','no_show','refunded'])->default('awaiting_payment');
            $table->integer('price_cents')->default(0);
            $table->integer('deposit_cents')->default(0);
            $table->integer('balance_cents')->default(0);
            $table->timestamps();
            $table->index(['agent_id','starts_at']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('bookings');
    }
};
