<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $patient = Auth::user()->patient;

        $upcoming = $patient
            ? Appointment::where('PatientID', $patient->PatientID)
                ->upcoming()
                ->with('therapist')
                ->limit(3)
                ->get()
            : collect();

        $next = $upcoming->first();

        return view('student.dashboard', compact('patient', 'upcoming', 'next'));
    }
}