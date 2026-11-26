<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table      = 'appointments';
    protected $primaryKey = 'AppointmentID';

    protected $fillable = [
        'PatientID', 'TherapistID', 'AppointmentDate', 'AppointmentTime',
        'DurationMinutes', 'Status', 'NotesForSession',
    ];

    protected $casts = [
        'AppointmentDate' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID', 'PatientID');
    }

    public function counsellor()
{
    return $this->belongsTo(Counsellor::class, 'CounsellorID');
}

    public function scopeUpcoming($q)
    {
        return $q->whereIn('Status', ['Booked'])
                 ->where(function ($w) {
                     $w->whereDate('AppointmentDate', '>', now()->toDateString())
                       ->orWhere(function ($t) {
                           $t->whereDate('AppointmentDate', now()->toDateString())
                             ->whereTime('AppointmentTime', '>=', now()->toTimeString());
                       });
                 })
                 ->orderBy('AppointmentDate')
                 ->orderBy('AppointmentTime');
    }
}