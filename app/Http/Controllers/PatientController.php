<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function dashboard()
    {
        $patient = Auth::user();

        $stats = [
            'pending'   => Appointment::where('patient_id', $patient->id)->where('status', 'pending')->count(),
            'accepted'  => Appointment::where('patient_id', $patient->id)->where('status', 'accepted')->count(),
            'completed' => Appointment::where('patient_id', $patient->id)->where('status', 'completed')->count(),
            'total'     => Appointment::where('patient_id', $patient->id)->count(),
        ];

        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->where('appointment_date', '>=', now())
            ->with('doctor')
            ->orderBy('appointment_date')
            ->take(5)
            ->get();

        $unreadCount = Message::where('receiver_id', $patient->id)
            ->where('is_read', false)
            ->count();

        return view('patient.dashboard', compact('stats', 'upcomingAppointments', 'unreadCount'));
    }

public function doctors(Request $request)
{
    $query = User::where('role', 'doctor');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('first_name', 'like', "%$search%")
              ->orWhere('last_name', 'like', "%$search%")
              ->orWhere('specialization', 'like', "%$search%");
        });
    }

    if ($request->filled('min_fee')) {
        $query->where('consultation_fee', '>=', $request->min_fee);
    }
    if ($request->filled('max_fee')) {
        $query->where('consultation_fee', '<=', $request->max_fee);
    }

    $doctors = $query->get()->map(function($d) {
        $d->avg_rating = $d->average_rating;
        return $d;
    });

    if ($request->filled('min_rating')) {
        $doctors = $doctors->filter(fn($d) => $d->avg_rating >= $request->min_rating);
    }

    if ($request->sort === 'fee_asc') {
        $doctors = $doctors->sortBy('consultation_fee');
    } elseif ($request->sort === 'fee_desc') {
        $doctors = $doctors->sortByDesc('consultation_fee');
    } elseif ($request->sort === 'rating') {
        $doctors = $doctors->sortByDesc('avg_rating');
    }

    $doctors = $doctors->values();

    return view('patient.doctors', compact('doctors'));
}

    public function doctorProfile(User $doctor)
    {
        abort_if($doctor->role !== 'doctor', 404);
        return view('patient.doctor-profile', compact('doctor'));
    }

    public function profile()
    {
        return view('patient.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());

        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'phone'      => 'nullable|string|max:20',
            'avatar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'   => 'nullable|min:8|confirmed',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}