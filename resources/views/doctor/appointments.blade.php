@extends('layouts.app')
@section('title', 'Rendez-vous')
@section('page-title', 'Mes Rendez-vous')

@section('content')
<div class="space-y-6">

    {{-- Filtres --}}
    <form method="GET" class="card rounded-2xl p-4 flex items-center gap-4 fade-up">
        <select name="status"
                class="px-4 py-2 rounded-xl text-sm text-white outline-none transition-all"
                style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
            <option value="">Tous les statuts</option>
            @foreach(['pending'=>'En attente','accepted'=>'Accepté','completed'=>'Terminé','cancelled'=>'Annulé'] as $val=>$lab)
                <option value="{{ $val }}" {{ request('status')===$val?'selected':'' }}>{{ $lab }}</option>
            @endforeach
        </select>
        <input type="date" name="date" value="{{ request('date') }}"
               class="px-4 py-2 rounded-xl text-sm text-white outline-none transition-all"
               style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
        <button type="submit" class="btn-teal px-5 py-2 rounded-xl text-sm font-medium text-white">
            Filtrer
        </button>
        @if(request('status') || request('date'))
            <a href="{{ route('doctor.appointments') }}"
               class="px-4 py-2 rounded-xl text-sm text-slate-400 hover:text-white transition-all"
               style="border:1px solid rgba(255,255,255,0.1)">
                Réinitialiser
            </a>
        @endif
    </form>

    {{-- Liste --}}
    <div class="space-y-3 fade-up-2">
        @forelse($appointments as $apt)
        <div class="card rounded-2xl p-5">
            <div class="flex items-start gap-4">

                {{-- Avatar patient --}}
                <div class="w-11 h-11 rounded-full overflow-hidden flex-shrink-0" style="border:2px solid rgba(255,255,255,0.1)">
                    @if($apt->patient->avatar)
                        <img src="{{ asset('storage/'.$apt->patient->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full teal-gradient flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr($apt->patient->first_name,0,1)) }}
                        </div>
                    @endif
                </div>

                {{-- Infos --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-1">
                        <p class="text-white font-medium">
                            {{ $apt->patient->first_name }} {{ $apt->patient->last_name }}
                        </p>
                        <span class="text-xs px-2 py-0.5 rounded-lg status-{{ $apt->status }}">
                            {{ ['pending'=>'En attente','accepted'=>'Accepté','completed'=>'Terminé','cancelled'=>'Annulé'][$apt->status] }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-400">
                        📅 {{ $apt->appointment_date->format('d/m/Y à H:i') }}
                    </p>
                    @if($apt->reason)
                        <p class="text-sm text-slate-400 mt-1">💬 {{ $apt->reason }}</p>
                    @endif
                    @if($apt->notes)
                        <div class="mt-2 px-3 py-2 rounded-lg text-sm text-slate-300"
                             style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2)">
                            📋 {{ $apt->notes }}
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="flex flex-col gap-2 flex-shrink-0">
                    @if($apt->status === 'pending')
                        <form method="POST" action="{{ route('doctor.appointments.status', $apt) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="accepted">
                            <button class="w-full px-4 py-1.5 rounded-lg text-xs font-medium text-white transition-all"
                                    style="background:#14532d;border:1px solid #166534">
                                ✓ Accepter
                            </button>
                        </form>
                        <form method="POST" action="{{ route('doctor.appointments.status', $apt) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button class="w-full px-4 py-1.5 rounded-lg text-xs font-medium text-red-400 transition-all"
                                    style="background:#4c051922;border:1px solid #7f1d1d55">
                                ✗ Refuser
                            </button>
                        </form>
                    @endif

                    @if($apt->status === 'accepted')
                        <form method="POST" action="{{ route('doctor.appointments.status', $apt) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button class="w-full px-4 py-1.5 rounded-lg text-xs font-medium text-white transition-all"
                                    style="background:#1e3a5f;border:1px solid #1e40af">
                                ✓ Terminer
                            </button>
                        </form>
                    @endif

                    @if($apt->status === 'completed' && !$apt->notes)
                        <button onclick="document.getElementById('notes-{{ $apt->id }}').classList.toggle('hidden')"
                                class="px-4 py-1.5 rounded-lg text-xs font-medium transition-all"
                                style="background:rgba(13,148,136,0.15);color:#2dd4bf;border:1px solid rgba(13,148,136,0.3)">
                            + Ajouter notes
                        </button>
                    @endif
                </div>
            </div>

            {{-- Formulaire notes --}}
            @if($apt->status === 'completed' && !$apt->notes)
            <div id="notes-{{ $apt->id }}" class="hidden mt-4 pt-4" style="border-top:1px solid rgba(255,255,255,0.07)">
                <form method="POST" action="{{ route('doctor.appointments.notes', $apt) }}">
                    @csrf
                    <textarea name="notes" rows="3" placeholder="Notes de consultation..."
                              class="w-full px-4 py-2.5 rounded-xl text-sm text-white placeholder-slate-500 resize-none mb-3"
                              style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)"></textarea>
                    <button type="submit" class="btn-teal px-5 py-2 rounded-xl text-sm font-medium text-white">
                        Sauvegarder
                    </button>
                </form>
            </div>
            @endif
        </div>
        @empty
        <div class="card rounded-2xl p-12 text-center">
            <svg class="mx-auto mb-3 opacity-20" width="48" height="48" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <p class="text-slate-400">Aucun rendez-vous trouvé</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="fade-up-3">{{ $appointments->appends(request()->query())->links() }}</div>
</div>
@endsection