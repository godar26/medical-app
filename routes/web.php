<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ReviewController;

// Redirect racine
Route::get('/', fn() => redirect()->route('login'));

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Doctor
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments', [AppointmentController::class, 'doctorIndex'])->name('appointments');
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');
    Route::post('/appointments/{appointment}/notes', [AppointmentController::class, 'addNotes'])->name('appointments.notes');
    Route::get('/messages', [MessageController::class, 'doctorIndex'])->name('messages');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'send'])->name('messages.send');
    Route::get('/profile', [DoctorController::class, 'profile'])->name('profile');
    Route::put('/profile', [DoctorController::class, 'updateProfile'])->name('profile.update');
    Route::get('/blocked-dates', [DoctorController::class, 'blockedDates'])->name('blocked-dates');
    Route::post('/blocked-dates', [DoctorController::class, 'storeBlockedDate'])->name('blocked-dates.store');
    Route::delete('/blocked-dates/{blockedDate}', [DoctorController::class, 'destroyBlockedDate'])->name('blocked-dates.destroy');
    Route::get('/appointments/export-pdf', [AppointmentController::class, 'exportPdf'])->name('appointments.pdf');
});

// Patient
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/doctors', [PatientController::class, 'doctors'])->name('doctors');
    Route::get('/doctors/{doctor}', [PatientController::class, 'doctorProfile'])->name('doctors.show');
    Route::post('/appointments/{doctor}', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments', [AppointmentController::class, 'patientIndex'])->name('appointments');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::get('/messages', [MessageController::class, 'patientIndex'])->name('messages');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'send'])->name('messages.send');
    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
    Route::put('/profile', [PatientController::class, 'updateProfile'])->name('profile.update');
    Route::post('/reviews/{appointment}', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/appointments/export-pdf', [AppointmentController::class, 'exportPdfPatient'])->name('appointments.pdf');
});

Route::get('/lang/{locale}', function($locale) {
    abort_if(!in_array($locale, ['fr', 'en', 'ar']), 404);
    session(['locale' => $locale]);
    return redirect()->back();
})->name('lang.switch');