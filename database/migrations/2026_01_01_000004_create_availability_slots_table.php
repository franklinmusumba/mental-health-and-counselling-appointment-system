<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('availability_slots', function (Blueprint $table) {
            $table->id('SlotID');
            $table->foreignId('TherapistID')
                  ->constrained('therapists', 'TherapistID')
                  ->cascadeOnDelete();
            $table->date('SlotDate');
            $table->time('SlotTime');
            $table->boolean('IsBooked')->default(false);
            $table->timestamps();

            $table->unique(['TherapistID', 'SlotDate', 'SlotTime']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availability_slots');
    }
};