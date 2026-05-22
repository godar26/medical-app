@extends('layouts.app')
@section('title', 'Mes Rendez-vous')
@section('page-title', 'Mes Rendez-vous')

@section('content')
<div class="space-y-6">

    {{-- Filtre --}}
    <form method="GET" class="card rounded-2xl p-4 flex gap-4 fade-up">
        <select name="status"
                class="px-4 py-2 rounded-xl text-sm text-white outline-none"
                style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
            <option value="">Tous les statuts</option>
            @foreach(['pending'=>'En attente','accepted'=>'Accepté','completed'=>'Terminé','cancelled'=>'Annulé'] as $val=>$lab)
                <option value="{{ $val }}" {{ request('status')===$val?'selected':'' }}>{{ $lab }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-teal px-5 py-2 rounded-xl text-sm font-medium text-white">Filtrer</button>
        @if(request('status'))
            <a href="{{ route('patient.appointments') }}"
               class="px-4 py-2 rounded-xl text-sm text-slate-400 transition-all"
               style="border:1px solid rgba(255,255,255,0.1)">Réinitialiser</a>
        @endif
    </form>
        {{-- Export PDF --}}
    <div class="flex justify-end fade-up">
    <a href="{{ auth()->user()->isDoctor() ? route('doctor.appointments.pdf') : route('patient.appointments.pdf') }}"
       class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium transition-all"
       style="background:rgba(239,68,68,0.15);color:#f87171;border:1px solid rgba(239,68,68,0.3)">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="12" y1="18" x2="12" y2="12"/>
            <line x1="9" y1="15" x2="15" y2="15"/>
        </svg>
        Exporter PDF
    </a>
</div>

    {{-- Liste --}}
    <div class="space-y-3 fade-up-2">
        @forelse($appointments as $apt)
        <div class="card rounded-2xl p-5 flex items-start gap-4">

            <div class="w-12 h-12 rounded-2xl overflow-hidden flex-shrink-0" style="border:2px solid rgba(13,148,136,0.3)">
                @if($apt->doctor->avatar)
                    <img src="{{ asset('storage/'.$apt->doctor->avatar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full teal-gradient flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($apt->doctor->first_name,0,1)) }}
                    </div>
                @endif
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 mb-1">
                    <p class="text-white font-medium">
                        Dr. {{ $apt->doctor->first_name }} {{ $apt->doctor->last_name }}
                    </p>
                    <span class="text-xs px-2 py-0.5 rounded-lg status-{{ $apt->status }}">
                        {{ ['pending'=>'En attente','accepted'=>'Accepté','completed'=>'Terminé','cancelled'=>'Annulé'][$apt->status] }}
                    </span>
                </div>
                <p class="text-sm text-slate-400">{{ $apt->doctor->specialization }}</p>
                <p class="text-sm text-slate-400 mt-1">📅 {{ $apt->appointment_date->format('d/m/Y à H:i') }}</p>
                @if($apt->reason)
                    <p class="text-sm text-slate-400 mt-1">💬 {{ $apt->reason }}</p>
                @endif
                @if($apt->notes)
                    <div class="mt-2 px-3 py-2 rounded-lg text-sm text-slate-300"
                         style="background:rgba(96,165,250,0.1);border:1px solid rgba(96,165,250,0.2)">
                        📋 Notes du médecin : {{ $apt->notes }}
                    </div>
                @endif
            </div>

            {{-- Notation --}}
            @if($apt->status === 'completed' && !$apt->review)
            <div class="mt-3 pt-3" style="border-top:1px solid rgba(255,255,255,0.07)">
                <p class="text-xs text-slate-400 mb-2">Noter cette consultation :</p>
                <form method="POST" action="{{ route('patient.reviews.store', $apt) }}" class="space-y-2">
                    @csrf
                    <div class="flex items-center gap-1" id="stars-{{ $apt->id }}">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button"
                                onclick="setRating({{ $apt->id }}, {{ $i }})"
                                class="star-btn text-2xl transition-all"
                                data-value="{{ $i }}"
                                style="color:#334155">★</button>
                        @endfor
                        <input type="hidden" name="rating" id="rating-{{ $apt->id }}" required>
                    </div>
                    <input type="text" name="comment" placeholder="Commentaire (optionnel)"
                        class="w-full px-3 py-2 rounded-lg text-sm text-white placeholder-slate-500 outline-none"
                        style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                    <button type="submit"
                            class="px-4 py-1.5 rounded-lg text-xs font-medium text-white transition-all"
                            style="background:rgba(13,148,136,0.3);border:1px solid rgba(13,148,136,0.5)">
                        Soumettre l'avis
                    </button>
                </form>
            </div>
            @endif

            @if($apt->review)
            <div class="mt-3 pt-3 flex items-center gap-2" style="border-top:1px solid rgba(255,255,255,0.07)">
                <div class="flex">
                    @for($i = 1; $i <= 5; $i++)
                        <span style="color:{{ $i <= $apt->review->rating ? '#fbbf24' : '#334155' }}">★</span>
                    @endfor
                </div>
                <span class="text-xs text-slate-400">{{ $apt->review->comment }}</span>
            </div>
            @endif

            {{-- Annuler --}}
            @if(in_array($apt->status, ['pending','accepted']))
            <form method="POST" action="{{ route('patient.appointments.cancel', $apt) }}">
                @csrf @method('PATCH')
                <button type="submit"
                        onclick="return confirm('Annuler ce rendez-vous ?')"
                        class="px-4 py-1.5 rounded-lg text-xs font-medium text-red-400 transition-all"
                        style="background:#4c051922;border:1px solid #7f1d1d55">
                    Annuler
                </button>
            </form>
            @endif
        </div>
        @empty
        <div class="card rounded-2xl p-12 text-center">
            <svg class="mx-auto mb-3 opacity-20" width="48" height="48" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <p class="text-slate-400 mb-3">Aucun rendez-vous trouvé</p>
            <a href="{{ route('patient.doctors') }}" class="btn-teal inline-block px-5 py-2 rounded-xl text-sm font-medium text-white">
                Prendre un RDV →
            </a>
        </div>
        @endforelse
    </div>

    <div>{{ $appointments->appends(request()->query())->links() }}</div>
</div>
@endsection

@push('scripts')
<script>
function setRating(aptId, value) {
    document.getElementById('rating-' + aptId).value = value;
    const container = document.getElementById('stars-' + aptId);
    container.querySelectorAll('.star-btn').forEach(btn => {
        btn.style.color = parseInt(btn.dataset.value) <= value ? '#fbbf24' : '#334155';
    });
}
</script>
@endpush