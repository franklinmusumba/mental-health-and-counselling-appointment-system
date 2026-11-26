<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionNote extends Model
{
    protected $table      = 'session_notes';
    protected $primaryKey = 'SessionNoteID';
    
    // If your table doesn't have created_at/updated_at, keep this false
    public $timestamps = false; 

    protected $fillable = [
        'AppointmentID', 
        'CounsellorID', 
        'NoteContent', 
        'CreatedDate', 
        'IsConfidential'
    ];

    protected $casts = [
        'CreatedDate' => 'datetime',
        'IsConfidential' => 'boolean',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'AppointmentID', 'AppointmentID');
    }

    public function counsellor()
    {
        return $this->belongsTo(Counsellor::class, 'CounsellorID', 'CounsellorID');
    }
}