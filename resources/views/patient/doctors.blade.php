@extends('layouts.app')
@section('title', 'Médecins')
@section('page-title', 'Trouver un Médecin')

@section('content')
<div class="space-y-6">

{{-- Recherche & Filtres --}}
<form method="GET" class="card rounded-2xl p-5 space-y-4 fade-up">
    {{-- Recherche texte --}}
    <div class="relative">
        <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500" width="16" height="16"
             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Rechercher par nom ou spécialisation..."
               class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm text-white placeholder-slate-500 outline-none"
               style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
    </div>

    {{-- Filtres avancés --}}
    <div class="grid grid-cols-4 gap-3">
        <div>
            <label class="text-xs text-slate-400 mb-1 block">Prix min (MAD)</label>
            <input type="number" name="min_fee" value="{{ request('min_fee') }}" placeholder="0"
                   class="w-full px-3 py-2 rounded-xl text-sm text-white outline-none"
                   style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
        </div>
        <div>
            <label class="text-xs text-slate-400 mb-1 block">Prix max (MAD)</label>
            <input type="number" name="max_fee" value="{{ request('max_fee') }}" placeholder="1000"
                   class="w-full px-3 py-2 rounded-xl text-sm text-white outline-none"
                   style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
        </div>
        <div>
            <label class="text-xs text-slate-400 mb-1 block">Note minimum</label>
            <select name="min_rating"
                    class="w-full px-3 py-2 rounded-xl text-sm text-white outline-none"
                    style="background:rgba(30,41,59,1);border:1px solid rgba(255,255,255,0.1)">
                <option value="">Toutes</option>
                @foreach([4=>'4★+', 3=>'3★+', 2=>'2★+', 1=>'1★+'] as $val=>$lab)
                    <option value="{{ $val }}" {{ request('min_rating')==$val?'selected':'' }}>{{ $lab }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs text-slate-400 mb-1 block">Trier par</label>
            <select name="sort"
                    class="w-full px-3 py-2 rounded-xl text-sm text-white outline-none"
                    style="background:rgba(30,41,59,1);border:1px solid rgba(255,255,255,0.1)">
                <option value="">Par défaut</option>
                <option value="fee_asc"  {{ request('sort')==='fee_asc'?'selected':'' }}>Prix croissant</option>
                <option value="fee_desc" {{ request('sort')==='fee_desc'?'selected':'' }}>Prix décroissant</option>
                <option value="rating"   {{ request('sort')==='rating'?'selected':'' }}>Mieux notés</option>
            </select>
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="btn-teal px-6 py-2.5 rounded-xl text-sm font-medium text-white">
            Appliquer les filtres
        </button>
        <a href="{{ route('patient.doctors') }}"
           class="px-4 py-2.5 rounded-xl text-sm text-slate-400 hover:text-white transition-all"
           style="border:1px solid rgba(255,255,255,0.1)">
            Réinitialiser
        </a>
    </div>
</form>

    {{-- Grille médecins --}}
    <div class="grid grid-cols-3 gap-5 fade-up-2">
        @forelse($doctors as $doctor)
        <div class="card rounded-2xl p-6 flex flex-col hover:border-teal-800 transition-all">

            {{-- Avatar + infos --}}
            <div class="flex items-center gap-4 mb-4">
                <div class="w-14 h-14 rounded-2xl overflow-hidden flex-shrink-0" style="border:2px solid rgba(13,148,136,0.4)">
                    @if($doctor->avatar)
                        <img src="{{ asset('storage/'.$doctor->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full teal-gradient flex items-center justify-center text-white text-xl font-bold">
                            {{ strtoupper(substr($doctor->first_name,0,1)) }}
                        </div>
                    @endif
                </div>
                <div class="min-w-0">
                    <p class="text-white font-semibold truncate">
                        Dr. {{ $doctor->first_name }} {{ $doctor->last_name }}
                    </p>
                    <p class="text-sm mt-0.5" style="color:#2dd4bf">{{ $doctor->specialization }}</p>
                </div>
                {{-- Note moyenne --}}
                    <div class="flex items-center gap-1 mt-1">
                        @php $avg = $doctor->average_rating; @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <span class="text-sm" style="color:{{ $i <= $avg ? '#fbbf24' : '#334155' }}">★</span>
                        @endfor
                        <span class="text-xs text-slate-400 ml-1">
                            {{ $avg > 0 ? $avg . '/5' : 'Pas encore noté' }}
                        </span>
                    </div>
            </div>

            {{-- Bio --}}
            @if($doctor->biography)
            <p class="text-slate-400 text-sm leading-relaxed mb-4 flex-1 line-clamp-3">
                {{ $doctor->biography }}
            </p>
            @endif

            {{-- Frais --}}
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs text-slate-500">Consultation</span>
                <span class="font-semibold text-white">{{ number_format($doctor->consultation_fee, 0) }} MAD</span>
            </div>

            {{-- Actions --}}
            <a href="{{ route('patient.doctors.show', $doctor) }}"
               class="btn-teal w-full py-2.5 rounded-xl text-sm font-medium text-white text-center">
                Voir le profil & Prendre RDV
            </a>
        </div>
        @empty
        <div class="col-span-3 card rounded-2xl p-12 text-center">
            <svg class="mx-auto mb-3 opacity-20" width="48" height="48" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
            </svg>
            <p class="text-slate-400">Aucun médecin trouvé pour "{{ request('search') }}"</p>
        </div>
        @endforelse
    </div>
</div>
@endsection