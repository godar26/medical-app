@extends('layouts.app')
@section('title', 'Dates bloquées')
@section('page-title', 'Gérer mes indisponibilités')

@section('content')
<div class="grid grid-cols-2 gap-6">

    {{-- Formulaire --}}
    <div class="card rounded-2xl p-6 fade-up">
        <h3 class="text-white font-semibold mb-5">Bloquer une date</h3>

        <form method="POST" action="{{ route('doctor.blocked-dates.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs text-slate-400 mb-1 block">Date à bloquer</label>
                <input type="date" name="blocked_date"
                       min="{{ now()->addDay()->format('Y-m-d') }}"
                       required
                       class="w-full px-4 py-2.5 rounded-xl text-sm text-white outline-none transition-all"
                       style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
            </div>
            <div>
                <label class="text-xs text-slate-400 mb-1 block">Raison (optionnel)</label>
                <input type="text" name="reason" placeholder="Congé, formation..."
                       class="w-full px-4 py-2.5 rounded-xl text-sm text-white placeholder-slate-500 outline-none transition-all"
                       style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
            </div>
            <button type="submit" class="btn-teal w-full py-3 rounded-xl text-sm font-semibold text-white">
                Bloquer cette date
            </button>
        </form>
    </div>

    {{-- Liste --}}
    <div class="card rounded-2xl p-6 fade-up-2">
        <h3 class="text-white font-semibold mb-5">Dates bloquées</h3>
        <div class="space-y-3">
            @forelse($blockedDates as $bd)
            <div class="flex items-center justify-between py-3"
                 style="border-bottom:1px solid rgba(255,255,255,0.05)">
                <div>
                    <p class="text-white text-sm font-medium">
                        {{ $bd->blocked_date->format('d/m/Y') }}
                    </p>
                    @if($bd->reason)
                        <p class="text-xs text-slate-400">{{ $bd->reason }}</p>
                    @endif
                </div>
                <form method="POST" action="{{ route('doctor.blocked-dates.destroy', $bd) }}">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1 rounded-lg text-xs text-red-400 transition-all"
                            style="background:#4c051922;border:1px solid #7f1d1d55">
                        Débloquer
                    </button>
                </form>
            </div>
            @empty
                <p class="text-slate-400 text-sm text-center py-6">Aucune date bloquée</p>
            @endforelse
        </div>
    </div>
</div>
@endsection