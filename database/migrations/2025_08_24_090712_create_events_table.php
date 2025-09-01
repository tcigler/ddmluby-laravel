<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->text('program')->nullable();
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->timestamp('show_from');
            $table->timestamp('registration_from')->nullable();
            $table->boolean('registration_open');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('events');
    }
};
