@extends('layouts.app')
@section('title', 'Dashboard Médecin')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">

{{-- Stats --}}
<div class="grid grid-cols-4 gap-4 fade-up">

    <div class="card rounded-2xl p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background:#854d0e22">
            <svg width="20" height="20" fill="none" stroke="#fbbf24" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-semibold text-white">{{ $stats['pending'] }}</p>
            <p class="text-xs text-slate-400">En attente</p>
        </div>
    </div>

    <div class="card rounded-2xl p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background:#14532d22">
            <svg width="20" height="20" fill="none" stroke="#4ade80" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-semibold text-white">{{ $stats['accepted'] }}</p>
            <p class="text-xs text-slate-400">Acceptés</p>
        </div>
    </div>

    <div class="card rounded-2xl p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background:#1e3a5f22">
            <svg width="20" height="20" fill="none" stroke="#60a5fa" stroke-width="2" viewBox="0 0 24 24">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-semibold text-white">{{ $stats['completed'] }}</p>
            <p class="text-xs text-slate-400">Terminés</p>
        </div>
    </div>

    <div class="card rounded-2xl p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
             style="background:rgba(13,148,136,0.15)">
            <svg width="20" height="20" fill="none" stroke="#2dd4bf" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-semibold text-white">{{ $stats['total'] }}</p>
            <p class="text-xs text-slate-400">Total</p>
        </div>
    </div>

</div>

    <div class="grid grid-cols-2 gap-6">

        {{-- RDV du jour --}}
        <div class="card rounded-2xl p-6 fade-up-2">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-semibold text-white">Rendez-vous du jour</h2>
                <span class="text-xs px-3 py-1 rounded-full" style="background:rgba(13,148,136,0.2);color:#2dd4bf">
                    {{ today()->format('d/m/Y') }}
                </span>
            </div>

            @forelse($todayAppointments as $apt)
            <div class="flex items-center gap-4 py-3" style="border-bottom:1px solid rgba(255,255,255,0.05)">
                <div class="w-9 h-9 rounded-full flex-shrink-0 overflow-hidden" style="border:1px solid rgba(255,255,255,0.1)">
                    @if($apt->patient->avatar)
                        <img src="{{ asset('storage/'.$apt->patient->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full teal-gradient flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr($apt->patient->first_name,0,1)) }}
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-white font-medium truncate">
                        {{ $apt->patient->first_name }} {{ $apt->patient->last_name }}
                    </p>
                    <p class="text-xs text-slate-400">{{ $apt->appointment_date->format('H:i') }}</p>
                </div>
                <span class="text-xs px-2 py-1 rounded-lg status-{{ $apt->status }}">
                    {{ ucfirst($apt->status) }}
                </span>
            </div>
            @empty
            <div class="text-center py-8 text-slate-500">
                <svg class="mx-auto mb-2 opacity-30" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                <p class="text-sm">Aucun rendez-vous aujourd'hui</p>
            </div>
            @endforelse
        </div>

        {{-- Activité récente --}}
        <div class="card rounded-2xl p-6 fade-up-3">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-semibold text-white">Activité récente</h2>
                @if($unreadCount > 0)
                <span class="text-xs px-3 py-1 rounded-full font-medium" style="background:#854d0e33;color:#fbbf24">
                    {{ $unreadCount }} non lu{{ $unreadCount > 1 ? 's' : '' }}
                </span>
                @endif
            </div>

            @forelse($recentAppointments as $apt)
            <div class="flex items-center gap-3 py-3" style="border-bottom:1px solid rgba(255,255,255,0.05)">
                <div class="w-2 h-2 rounded-full flex-shrink-0 mt-1
                    {{ $apt->status === 'pending' ? 'bg-yellow-400' :
                      ($apt->status === 'accepted' ? 'bg-green-400' :
                      ($apt->status === 'completed' ? 'bg-blue-400' : 'bg-red-400')) }}">
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-white truncate">
                        {{ $apt->patient->first_name }} {{ $apt->patient->last_name }}
                    </p>
                    <p class="text-xs text-slate-400">{{ $apt->appointment_date->format('d/m/Y à H:i') }}</p>
                </div>
                <span class="text-xs px-2 py-1 rounded-lg status-{{ $apt->status }}">
                    {{ $apt->status === 'pending' ? 'En attente' :
                      ($apt->status === 'accepted' ? 'Accepté' :
                      ($apt->status === 'completed' ? 'Terminé' : 'Annulé')) }}
                </span>
            </div>
            @empty
            <p class="text-center text-slate-500 text-sm py-8">Aucune activité récente</p>
            @endforelse

            <a href="{{ route('doctor.appointments') }}"
               class="mt-4 flex items-center justify-center gap-2 text-sm py-2.5 rounded-xl transition-all"
               style="color:#2dd4bf;border:1px solid rgba(13,148,136,0.3)">
                Voir tous les rendez-vous →
            </a>
        </div>
    </div>

    {{-- Accès rapides --}}
    <div class="grid grid-cols-3 gap-4 fade-up-4">
        <a href="{{ route('doctor.appointments') }}?status=pending"
           class="card rounded-2xl p-5 flex items-center gap-4 hover:border-teal-800 transition-all group">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#854d0e22">
                <svg width="18" height="18" fill="none" stroke="#fbbf24" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <p class="text-white text-sm font-medium">Demandes en attente</p>
                <p class="text-slate-400 text-xs">{{ $stats['pending'] }} à traiter</p>
            </div>
        </a>
        <a href="{{ route('doctor.messages') }}"
           class="card rounded-2xl p-5 flex items-center gap-4 hover:border-teal-800 transition-all group">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(13,148,136,0.15)">
                <svg width="18" height="18" fill="none" stroke="#2dd4bf" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-white text-sm font-medium">Messages</p>
                <p class="text-slate-400 text-xs">{{ $unreadCount }} non lu{{ $unreadCount > 1 ? 's' : '' }}</p>
            </div>
        </a>
        <a href="{{ route('doctor.profile') }}"
           class="card rounded-2xl p-5 flex items-center gap-4 hover:border-teal-800 transition-all group">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#1e3a5f33">
                <svg width="18" height="18" fill="none" stroke="#60a5fa" stroke-width="2" viewBox="0 0 24 24">
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