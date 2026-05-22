<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AppointmentController extends Controller
{
    // DOCTOR
    public function doctorIndex(Request $request)
    {
        $query = Appointment::where('doctor_id', Auth::id())->with('patient');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->orderByDesc('appointment_date')->paginate(10);
        return view('doctor.appointments', compact('appointments'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        abort_if($appointment->doctor_id !== Auth::id(), 403);

        $request->validate(['status' => 'required|in:accepted,cancelled,completed']);
        $appointment->update(['status' => $request->status]);

        return back()->with('success', 'Statut mis à jour.');
    }

    public function addNotes(Request $request, Appointment $appointment)
    {
        abort_if($appointment->doctor_id !== Auth::id(), 403);
        abort_if($appointment->status !== 'completed', 403);

        $request->validate(['notes' => 'required|string|max:2000']);
        $appointment->update(['notes' => $request->notes]);

        return back()->with('success', 'Notes ajoutées.');
    }

    // PATIENT
    public function store(Request $request, User $doctor)
    {
        abort_if($doctor->role !== 'doctor', 404);

        $request->validate([
            'appointment_date' => 'required|date|after:now',
            'reason'           => 'nullable|string|max:500',
        ]);

        Appointment::create([
            'patient_id'       => Auth::id(),
            'doctor_id'        => $doctor->id,
            'appointment_date' => $request->appointment_date,
            'reason'           => $request->reason,
            'status'           => 'pending',
        ]);

        return redirect()->route('patient.appointments')
            ->with('success', 'Rendez-vous demandé avec succès !');
    }

    public function patientIndex(Request $request)
    {
        $query = Appointment::where('patient_id', Auth::id())->with('doctor');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->orderByDesc('appointment_date')->paginate(10);
        return view('patient.appointments', compact('appointments'));
    }

    public function cancel(Appointment $appointment)
    {
        abort_if($appointment->patient_id !== Auth::id(), 403);
        abort_if(!in_array($appointment->status, ['pending', 'accepted']), 403);

        $appointment->update(['status' => 'cancelled']);
        return back()->with('success', 'Rendez-vous annulé.');
    }

    public function exportPdf()
    {
        $appointments = Appointment::where('doctor_id', Auth::id())
            ->with('patient')
            ->orderByDesc('appointment_date')
            ->get();

        $pdf = Pdf::loadView('pdf.appointments-doctor', compact('appointments'));
        return $pdf->download('mes-rendez-vous.pdf');
    }

    public function exportPdfPatient()
    {
        $appointments = Appointment::where('patient_id', Auth::id())
            ->with('doctor')
            ->orderByDesc('appointment_date')
            ->get();

        $pdf = Pdf::loadView('pdf.appointments-patient', compact('appointments'));
        return $pdf->download('mes-rendez-vous.pdf');
    }
}