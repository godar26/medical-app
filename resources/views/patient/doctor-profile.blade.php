@extends('layouts.app')
@section('title', 'Profil Médecin')
@section('page-title', 'Profil du Médecin')

@section('content')
<div class="grid grid-cols-3 gap-6">

    {{-- Profil gauche --}}
    <div class="space-y-5">
        <div class="card rounded-2xl p-6 text-center fade-up">
            <div class="w-24 h-24 rounded-2xl overflow-hidden mx-auto mb-4" style="border:3px solid rgba(13,148,136,0.5)">
                @if($doctor->avatar)
                    <img src="{{ asset('storage/'.$doctor->avatar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full teal-gradient flex items-center justify-center text-white text-3xl font-bold">
                        {{ strtoupper(substr($doctor->first_name,0,1)) }}
                    </div>
                @endif
            </div>
            <h2 class="text-white font-semibold text-lg">
                Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}
            </h2>
            <p class="mt-1 text-sm" style="color:#2dd4bf">{{ $doctor->specialization }}</p>

            <div class="mt-4 pt-4 flex justify-center" style="border-top:1px solid rgba(255,255,255,0.07)">
                <div class="text-center">
                    <p class="text-xl font-bold text-white">{{ number_format($doctor->consultation_fee,0) }} MAD</p>
                    <p class="text-xs text-slate-400">Frais de consultation</p>
                </div>
            </div>
        </div>

        @if($doctor->biography)
        <div class="card rounded-2xl p-5 fade-up-2">
            <h3 class="text-sm font-semibold text-white mb-3">Biographie</h3>
            <p class="text-slate-400 text-sm leading-relaxed">{{ $doctor->biography }}</p>
        </div>
        @endif

        {{-- Contacter --}}
        <a href="{{ route('patient.messages.show', $doctor) }}"
           class="card rounded-2xl p-4 flex items-center gap-3 hover:border-teal-800 transition-all fade-up-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(13,148,136,0.15)">
                <svg width="18" height="18" fill="none" stroke="#2dd4bf" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-white text-sm font-medium">Envoyer un message</p>
                <p class="text-slate-400 text-xs">Poser une question au médecin</p>
            </div>
        </a>
    </div>

    {{-- Formulaire RDV --}}
    <div class="col-span-2 fade-up-2">
        <div class="card rounded-2xl p-6">
            <h3 class="text-white font-semibold text-lg mb-6">Prendre un rendez-vous</h3>

            @if($errors->any())
                <div class="mb-5 px-4 py-3 rounded-xl text-sm"
                     style="background:#4c051922;color:#f87171;border:1px solid #7f1d1d55">
                    @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('patient.appointments.store', $doctor) }}" class="space-y-5">
                @csrf

                <div>
                    <label class="text-xs text-slate-400 mb-2 block">Date et heure souhaitées</label>
                    <input type="datetime-local" name="appointment_date"
                           value="{{ old('appointment_date') }}"
                           min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                           required
                           class="w-full px-4 py-3 rounded-xl text-sm text-white outline-none transition-all"
                           style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                </div>

                <div>
                    <label class="text-xs text-slate-400 mb-2 block">Motif de consultation (optionnel)</label>
                    <textarea name="reason" rows="4"
                              placeholder="Décrivez brièvement votre motif de consultation..."
                              class="w-full px-4 py-3 rounded-xl text-sm text-white placeholder-slate-500 resize-none outline-none transition-all"
                              style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">{{ old('reason') }}</textarea>
                </div>

                {{-- Résumé --}}
                <div class="rounded-xl p-4" style="background:rgba(13,148,136,0.1);border:1px solid rgba(13,148,136,0.2)">
                    <p class="text-sm text-slate-300 mb-2">Récapitulatif</p>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Médecin</span>
                        <span class="text-white">Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}</span>
                    </div>
                    <div class="flex justify-between text-sm mt-1">
                        <span class="text-slate-400">Spécialité</span>
                        <span class="text-white">{{ $doctor->specialization }}</span>
                    </div>
                    <div class="flex justify-between text-sm mt-1">
                        <span class="text-slate-400">Frais</span>
                        <span class="font-semibold" style="color:#2dd4bf">{{ number_format($doctor->consultation_fee,0) }} MAD</span>
                    </div>
                </div>

                <button type="submit" class="btn-teal w-full py-3 rounded-xl text-sm font-semibold text-white">
                    Confirmer la demande de rendez-vous →
                </button>
            </form>
        </div>
    </div>
</div>
@endsection