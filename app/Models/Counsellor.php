<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counsellor extends Model
{
    protected $table      = 'counsellors'; // The new table name in the DB
    protected $primaryKey = 'CounsellorID'; // The new primary key column

    protected $fillable = [
        'FirstName', 'LastName', 'Specialization', 'LicenseNumber',
        'Email', 'PhoneNumber', 'HireDate',
    ];

    protected $casts = ['HireDate' => 'date'];

    public function user()
    {
        // Change 'TherapistID' to 'CounsellorID'
        return $this->hasOne(User::class, 'CounsellorID', 'CounsellorID');
    }
}