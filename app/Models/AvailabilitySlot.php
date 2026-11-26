<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    protected $table      = 'availability_slots';
    protected $primaryKey = 'SlotID';

    protected $fillable = ['TherapistID', 'SlotDate', 'SlotTime', 'IsBooked'];

    protected $casts = [
        'SlotDate' => 'date',
        'IsBooked' => 'boolean',
    ];

    public function therapist()
    {
        return $this->belongsTo(Therapist::class, 'TherapistID', 'TherapistID');
    }
}