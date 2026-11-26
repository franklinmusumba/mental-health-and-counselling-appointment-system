<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('therapists', function (Blueprint $table) {
            $table->id('TherapistID');
            $table->string('FirstName', 50);
            $table->string('LastName', 50);
            $table->string('Specialization', 100)->nullable();
            $table->string('LicenseNumber', 50)->nullable();
            $table->string('Email', 100)->unique();
            $table->string('PhoneNumber', 15)->nullable();
            $table->date('HireDate')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('therapists');
    }
};