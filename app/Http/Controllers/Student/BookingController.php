<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use App\Models\Therapist;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /** Render the 3-step booking wizard. */
    public function index(Request $request)
    {
        $therapists = Therapist::orderBy('FirstName')->get();

        // Selected counsellor (default = first)
        $therapistId = (int) ($request->query('therapist_id') ?? $therapists->first()->TherapistID);
        $therapist   = $therapists->firstWhere('TherapistID', $therapistId) ?? $therapists->first();

        // Selected date (default = today)
        $dateStr = $request->query('date', now()->toDateString());
        try { $date = Carbon::parse($dateStr)->startOfDay(); }
        catch (\Exception $e) { $date = now()->startOfDay(); }

        $slots = AvailabilitySlot::where('TherapistID', $therapist->TherapistID)
            ->whereDate('SlotDate', $date->toDateString())
            ->orderBy('SlotTime')
            ->get();

        return view('student.book', compact('therapists', 'therapist', 'date', 'slots'));
    }

    /** Store a new appointment. */
    public function store(Request $request)
    {
        $data = $request->validate([
            'TherapistID' => ['required', 'exists:therapists,TherapistID'],
            'SlotID'      => ['required', 'exists:availability_slots,SlotID'],
        ]);

        $patient = Auth::user()->patient;
        if (!$patient) {
            return back()->withErrors(['slot' => 'Only patients can book appointments.']);
        }

        try {
            DB::transaction(function () use ($data, $patient) {
                $slot = AvailabilitySlot::where('SlotID', $data['SlotID'])->lockForUpdate()->first();

                if (!$slot || $slot->IsBooked) {
                    throw new \RuntimeException('That slot is no longer available.');
                }
                if ((int) $slot->TherapistID !== (int) $data['TherapistID']) {
                    throw new \RuntimeException('Mismatched therapist.');
                }

                Appointment::create([
                    'PatientID'       => $patient->PatientID,
                    'TherapistID'     => $slot->TherapistID,
                    'AppointmentDate' => $slot->SlotDate->toDateString(),
                    'AppointmentTime' => $slot->SlotTime,
                    'DurationMinutes' => 60,
                    'Status'          => 'Booked',
                ]);

                $slot->update(['IsBooked' => true]);
            });

            return redirect()->route('student.dashboard')
                ->with('success', 'Appointment booked successfully.');
        } catch (\RuntimeException $e) {
            return back()->withErrors(['slot' => $e->getMessage()]);
        }
    }
}