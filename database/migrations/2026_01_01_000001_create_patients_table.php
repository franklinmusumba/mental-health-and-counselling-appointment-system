<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id('PatientID');
            $table->string('FirstName', 50);
            $table->string('LastName', 50);
            $table->date('DateOfBirth');
            $table->string('Gender', 10)->nullable();
            $table->string('Email', 100)->unique();
            $table->string('PhoneNumber', 15)->nullable();
            $table->string('Address', 200)->nullable();
            $table->string('EmergencyContactName', 100)->nullable();
            $table->string('EmergencyContactPhone', 15)->nullable();
            $table->string('AnonymousID', 50)->nullable();
            $table->dateTime('RegistrationDate')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};