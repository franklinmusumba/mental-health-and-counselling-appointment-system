<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table      = 'user_logins';
    protected $primaryKey = 'UserID';

    protected $fillable = [
        // Changed TherapistID to CounsellorID
        'PatientID', 'CounsellorID', 'Username', 'PasswordHash', 'Role', 'LastLogin', 
    ];

    protected $hidden = ['PasswordHash'];

    protected $casts = [
        'LastLogin' => 'datetime',
    ];

    /* ---- Auth integration with custom column names (FR-05, NFR-04) ---- */

    public function getAuthPassword(): string
    {
        return $this->PasswordHash;
    }

    public function getAuthIdentifierName(): string
    {
        return 'UserID';
    }

    /* ---- Relationships ---- */

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID', 'PatientID');
    }

    // Renamed from therapist() to counsellor()
    public function counsellor()
    {
        return $this->belongsTo(Counsellor::class, 'CounsellorID', 'CounsellorID');
    }

    /* ---- Convenience ---- */

    public function displayName(): string
    {
        if ($this->patient) {
            return $this->patient->FirstName . ' ' . $this->patient->LastName;
        }
        // Changed to check the counsellor relationship
        if ($this->counsellor) {
            return $this->counsellor->FirstName . ' ' . $this->counsellor->LastName;
        }
        return $this->Username;
    }

    public function initials(): string
    {
        $name = $this->displayName();
        $parts = preg_split('/\s+/', $name);
        $first = $parts[0][0] ?? '';
        $last  = $parts[count($parts) - 1][0] ?? '';
        return strtoupper($first . $last);
    }
}