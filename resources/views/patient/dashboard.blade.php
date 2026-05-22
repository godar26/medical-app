@extends('layouts.app')
@section('title', 'Dashboard Patient')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Bienvenue --}}
    <div class="card rounded-2xl p-6 fade-up" style="background:linear-gradient(135deg,rgba(13,148,136,0.2),rgba(8,145,178,0.1));border-color:rgba(13,148,136,0.3)">
        <h2 class="text-xl font-semibold text-white mb-1">
            Bonjour, {{ Auth::user()->first_name }} 👋
        </h2>
        <p class="text-slate-400 text-sm">Gérez vos rendez-vous médicaux en toute simplicité.</p>
        <a href="{{ route('patient.doctors') }}"
           class="btn-teal inline-flex items-center gap-2 mt-4 px-5 py-2.5 rounded-xl text-sm font-medium text-white">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            Trouver un médecin
        </a>
    </div>

    {{-- Stats --}}
<div class="grid grid-cols-4 gap-4 fade-up-2">

    <div class="card rounded-2xl p-5">
        <p class="text-2xl font-semibold" style="color:#fbbf24">{{ $stats['pending'] }}</p>
        <p class="text-xs text-slate-400 mt-1">En attente</p>
    </div>

    <div class="card rounded-2xl p-5">
        <p class="text-2xl font-semibold" style="color:#4ade80">{{ $stats['accepted'] }}</p>
        <p class="text-xs text-slate-400 mt-1">Acceptés</p>
    </div>

    <div class="card rounded-2xl p-5">
        <p class="text-2xl font-semibold" style="color:#60a5fa">{{ $stats['completed'] }}</p>
        <p class="text-xs text-slate-400 mt-1">Terminés</p>
    </div>

    <div class="card rounded-2xl p-5">
        <p class="text-2xl font-semibold" style="color:#2dd4bf">{{ $stats['total'] }}</p>
        <p class="text-xs text-slate-400 mt-1">Total RDV</p>
    </div>

</div>

    {{-- Prochains RDV --}}
    <div class="card rounded-2xl p-6 fade-up-3">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-semibold text-white">Prochains rendez-vous</h2>
            <a href="{{ route('patient.appointments') }}" class="text-xs" style="color:#2dd4bf">Voir tout →</a>
        </div>

        @forelse($upcomingAppointments as $apt)
        <div class="flex items-center gap-4 py-3" style="border-bottom:1px solid rgba(255,255,255,0.05)">
            <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0">
                @if($apt->doctor->avatar)
                    <img src="{{ asset('storage/'.$apt->doctor->avatar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full teal-gradient flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr($apt->doctor->first_name,0,1)) }}
                    </div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm text-white font-medium">
                    Dr. {{ $apt->doctor->first_name }} {{ $apt->doctor->last_name }}
                </p>
                <p class="text-xs text-slate-400">
                    {{ $apt->doctor->specialization }} · {{ $apt->appointment_date->format('d/m/Y à H:i') }}
                </p>
            </div>
            <span class="text-xs px-2 py-1 rounded-lg status-{{ $apt->status }}">
                {{ $apt->status === 'pending' ? 'En attente' : 'Accepté' }}
            </span>
        </div>
        @empty
        <div class="text-center py-8 text-slate-500">
            <svg class="mx-auto mb-2 opacity-30" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <p class="text-sm">Aucun rendez-vous à venir</p>
            <a href="{{ route('patient.doctors') }}" class="text-xs mt-1 inline-block" style="color:#2dd4bf">
                Prendre un rendez-vous →
            </a>
        </div>
        @endforelse
    </div>

    {{-- Accès rapides --}}
    <div class="grid grid-cols-3 gap-4 fade-up-4">
        <a href="{{ route('patient.doctors') }}"
           class="card rounded-2xl p-5 flex items-center gap-4 hover:border-teal-800 transition-all">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(13,148,136,0.15)">
                <svg width="18" height="18" fill="none" stroke="#2dd4bf" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div>
                <p class="text-white text-sm font-medium">Chercher un médecin</p>
                <p class="text-slate-400 text-xs">Par nom ou spécialité</p>
            </div>
        </a>
        <a href="{{ route('patient.messages') }}"
           class="card rounded-2xl p-5 flex items-center gap-4 hover:border-teal-800 transition-all">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#1e3a5f33">
                <svg width="18" height="18" fill="none" stroke="#60a5fa" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-white text-sm font-medium">Messages</p>
                <p class="text-slate-400 text-xs">{{ $unreadCount }} non lu{{ $unreadCount > 1 ? 's' : '' }}</p>
            </div>
        </a>
        <a href="{{ route('patient.profile') }}"
           class="card rounded-2xl p-5 flex items-center gap-4 hover:border-teal-800 transition-all">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#854d0e22">
                <svg width="18" height="18" fill="none" stroke="#fbbf24" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div>
                <p class="text-white text-sm font-medium">Mon profil</p>
                <p class="text-slate-400 text-xs">Modifier mes infos</p>
            </div>
        </a>
    </div>
</div>
@endsection