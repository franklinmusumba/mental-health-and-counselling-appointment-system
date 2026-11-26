<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_logins', function (Blueprint $table) {
            $table->id('UserID');
            $table->unsignedBigInteger('PatientID')->nullable();
            $table->unsignedBigInteger('TherapistID')->nullable();
            $table->string('Username', 50)->unique();
            $table->string('PasswordHash', 255);
            $table->enum('Role', ['Patient', 'Therapist', 'Admin'])->default('Patient');
            $table->dateTime('LastLogin')->nullable();
            $table->timestamps();

            $table->foreign('PatientID')->references('PatientID')->on('patients')->nullOnDelete();
            $table->foreign('TherapistID')->references('TherapistID')->on('therapists')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_logins');
    }
};