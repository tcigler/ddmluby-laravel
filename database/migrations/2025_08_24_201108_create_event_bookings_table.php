<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('event_bookings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index();
            $table->string('ip_addr')->nullable();
            $table->foreignId('event_time_slot_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_info_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate()
                ->references("id")->on("user_info");
            $table->string('note')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('event_bookings');
    }
};
