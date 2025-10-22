<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('working_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('weekday'); // 0=Sun .. 6=Sat (Carbon)
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
            $table->unique(['agent_id','weekday']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('working_hours');
    }
};
