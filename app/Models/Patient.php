<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table      = 'patients';
    protected $primaryKey = 'PatientID';

    protected $fillable = [
        'FirstName', 'LastName', 'DateOfBirth', 'Gender', 'Email',
        'PhoneNumber', 'Address', 'EmergencyContactName',
        'EmergencyContactPhone', 'AnonymousID', 'RegistrationDate',
    ];

    protected $casts = [
        'DateOfBirth'      => 'date',
        'RegistrationDate' => 'datetime',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'PatientID', 'PatientID');
    }
}