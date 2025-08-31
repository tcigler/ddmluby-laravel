<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('event_time_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('time');
            $table->integer('capacity');
            $table->boolean('blocked')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('event_time_slots');
    }
};
