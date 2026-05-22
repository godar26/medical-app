<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\BlockedDate;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $doctor = Auth::user();

        $stats = [
            'pending'   => Appointment::where('doctor_id', $doctor->id)->where('status', 'pending')->count(),
            'accepted'  => Appointment::where('doctor_id', $doctor->id)->where('status', 'accepted')->count(),
            'completed' => Appointment::where('doctor_id', $doctor->id)->where('status', 'completed')->count(),
            'total'     => Appointment::where('doctor_id', $doctor->id)->count(),
        ];

        $todayAppointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->whereIn('status', ['pending', 'accepted'])
            ->with('patient')
            ->orderBy('appointment_date')
            ->get();

        $unreadCount = Message::where('receiver_id', $doctor->id)
            ->where('is_read', false)
            ->count();

        $recentAppointments = Appointment::where('doctor_id', $doctor->id)
            ->with('patient')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('doctor.dashboard', compact(
            'stats', 'todayAppointments', 'unreadCount', 'recentAppointments'
        ));
    }

    public function profile()
    {
        return view('doctor.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());

        $validated = $request->validate([
            'first_name'       => 'required|string|max:50',
            'last_name'        => 'required|string|max:50',
            'phone'            => 'nullable|string|max:20',
            'specialization'   => 'required|string|max:100',
            'consultation_fee' => 'required|numeric|min:0',
            'biography'        => 'required|string|max:1000',
            'avatar'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'         => 'nullable|min:8|confirmed',
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

    public function blockedDates()
    {
        $blockedDates = BlockedDate::where('doctor_id', Auth::id())
            ->orderBy('blocked_date')
            ->get();
        return view('doctor.blocked-dates', compact('blockedDates'));
    }

    public function storeBlockedDate(Request $request)
    {
        $request->validate([
            'blocked_date' => 'required|date|after:today',
            'reason'       => 'nullable|string|max:200',
        ]);

        BlockedDate::create([
            'doctor_id'    => Auth::id(),
            'blocked_date' => $request->blocked_date,
            'reason'       => $request->reason,
        ]);

        return back()->with('success', 'Date bloquée avec succès.');
    }

    public function destroyBlockedDate(BlockedDate $blockedDate)
    {
        abort_if($blockedDate->doctor_id !== Auth::id(), 403);
        $blockedDate->delete();
        return back()->with('success', 'Date débloquée.');
    }
}