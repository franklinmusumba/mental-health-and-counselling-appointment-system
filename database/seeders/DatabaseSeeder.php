<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Therapist;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
{
    // Admin
    User::create([
        'Username'     => 'admin@su.edu',
        'PasswordHash' => Hash::make('password123'),
        'Role'         => 'Admin',
    ]);

    // Counsellor 1 — Maya Chen
    $maya = Therapist::create([
        'FirstName'      => 'Maya',
        'LastName'       => 'Chen',
        'Specialization' => 'Anxiety & stress',
        'LicenseNumber'  => 'SU-COUN-28491',
        'Email'          => 'm.chen@su.edu',
        'PhoneNumber'    => '0700000001',
        'HireDate'       => '2024-01-15',
    ]);
    User::create([
        'Username'     => 'm.chen@su.edu',
        'PasswordHash' => Hash::make('password123'),
        'Role'         => 'Therapist',
        'TherapistID'  => $maya->TherapistID,
    ]);

    // Counsellor 2 — Kwame Mensah
    $kwame = Therapist::create([
        'FirstName'      => 'Kwame',
        'LastName'       => 'Mensah',
        'Specialization' => 'Depression & mood',
        'LicenseNumber'  => 'SU-COUN-28512',
        'Email'          => 'k.mensah@su.edu',
        'PhoneNumber'    => '0700000003',
        'HireDate'       => '2024-03-01',
    ]);
    User::create([
        'Username'     => 'k.mensah@su.edu',
        'PasswordHash' => Hash::make('password123'),
        'Role'         => 'Therapist',
        'TherapistID'  => $kwame->TherapistID,
    ]);

    // Patient
    $amara = Patient::create([
        'FirstName'   => 'Amara',
        'LastName'    => 'Smith',
        'DateOfBirth' => '2003-05-12',
        'Email'       => 'a.smith@su.edu',
        'PhoneNumber' => '0700000002',
    ]);
    User::create([
        'Username'     => 'a.smith@su.edu',
        'PasswordHash' => Hash::make('password123'),
        'Role'         => 'Patient',
        'PatientID'    => $amara->PatientID,
    ]);

    // Availability grid
    $this->call(AvailabilitySeeder::class);
}
}