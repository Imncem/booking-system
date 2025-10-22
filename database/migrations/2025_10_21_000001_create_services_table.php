<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('duration_min')->default(30);
            $table->integer('price_cents')->default(0);
            $table->integer('deposit_cents')->default(0);
            $table->integer('buffer_before_min')->default(0);
            $table->integer('buffer_after_min')->default(0);
            $table->integer('max_per_slot')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('services');
    }
};
