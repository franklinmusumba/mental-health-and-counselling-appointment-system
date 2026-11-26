<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('AppointmentID');
            $table->foreignId('PatientID')
                  ->constrained('patients', 'PatientID')
                  ->cascadeOnDelete();
            $table->foreignId('TherapistID')
                  ->constrained('therapists', 'TherapistID')
                  ->cascadeOnDelete();
            $table->date('AppointmentDate');
            $table->time('AppointmentTime');
            $table->integer('DurationMinutes')->default(60);
            $table->string('Status', 20)->default('Booked');
            $table->text('NotesForSession')->nullable();
            $table->timestamps();

            $table->unique(['TherapistID', 'AppointmentDate', 'AppointmentTime']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};