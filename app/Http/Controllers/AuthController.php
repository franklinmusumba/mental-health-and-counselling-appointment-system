<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->Role);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt(
            ['Username' => $credentials['email'], 'password' => $credentials['password']],
            $request->boolean('remember')
        )) {
            $request->session()->regenerate();

            $user = Auth::user();
            $user->LastLogin = now();
            $user->save();

            return $this->redirectByRole($user->Role);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Invalid credentials. Please check your email and password.']);
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->Role);
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name'  => ['required', 'string', 'max:50'],
            'email'      => ['required', 'email', 'max:100', 'unique:user_logins,Username'],
            'dob'        => ['required', 'date', 'before:today'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.unique'       => 'This email is already registered.',
            'password.confirmed' => 'The passwords do not match.',
            'password.min'       => 'Password must be at least 8 characters.',
        ]);

        DB::transaction(function () use ($data) {
            $patient = Patient::create([
                'FirstName'   => $data['first_name'],
                'LastName'    => $data['last_name'],
                'Email'       => $data['email'],
                'DateOfBirth' => $data['dob'],
            ]);

            User::create([
                'Username'     => $data['email'],
                'PasswordHash' => Hash::make($data['password']),
                'Role'         => 'Patient',
                'PatientID'    => $patient->PatientID,
            ]);
        });

        return redirect()->route('login')->with('registered', true);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'Patient'   => redirect()->route('student.dashboard'),
            'Therapist' => redirect()->route('counsellor.schedule'),
            'Admin'     => redirect()->route('admin.dashboard'),
            default     => redirect()->route('login'),
        };
    }
}