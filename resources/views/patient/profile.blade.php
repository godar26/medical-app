@extends('layouts.app')
@section('title', 'Mon Profil')
@section('page-title', 'Mon Profil')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card rounded-2xl p-8 fade-up">

        <div class="flex items-center gap-5 mb-8 pb-8" style="border-bottom:1px solid rgba(255,255,255,0.07)">
            <div class="w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0" style="border:3px solid rgba(13,148,136,0.4)">
                @if($user->avatar)
                    <img src="{{ asset('storage/'.$user->avatar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full teal-gradient flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($user->first_name,0,1)) }}
                    </div>
                @endif
            </div>
            <div>
                <h2 class="text-white font-semibold text-lg">{{ $user->first_name }} {{ $user->last_name }}</h2>
                <p class="text-slate-400 text-sm">{{ $user->email }}</p>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-5 px-4 py-3 rounded-xl text-sm"
                 style="background:#4c051922;color:#f87171;border:1px solid #7f1d1d55">
                @foreach($errors->all() as $e)<p>• {{ $e }}</p>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('patient.profile.update') }}"
              enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-slate-400 mb-1 block">Prénom</label>
                    <input name="first_name" value="{{ old('first_name', $user->first_name) }}" type="text" required
                           class="w-full px-4 py-2.5 rounded-xl text-sm text-white outline-none transition-all"
                           style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                </div>
                <div>
                    <label class="text-xs text-slate-400 mb-1 block">Nom</label>
                    <input name="last_name" value="{{ old('last_name', $user->last_name) }}" type="text" required
                           class="w-full px-4 py-2.5 rounded-xl text-sm text-white outline-none transition-all"
                           style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                </div>
            </div>

            <div>
                <label class="text-xs text-slate-400 mb-1 block">Téléphone</label>
                <input name="phone" value="{{ old('phone', $user->phone) }}" type="text"
                       class="w-full px-4 py-2.5 rounded-xl text-sm text-white outline-none transition-all"
                       style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
            </div>

            <div style="border-top:1px solid rgba(255,255,255,0.07)" class="pt-5 space-y-4">
                <div>
                    <label class="text-xs text-slate-400 mb-1 block">Nouvelle photo</label>
                    <input name="avatar" type="file" accept=".jpg,.jpeg,.png"
                           class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-400 transition-all cursor-pointer file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:cursor-pointer file:text-white file:bg-teal-600"
                           style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs text-slate-400 mb-1 block">Nouveau mot de passe</label>
                        <input name="password" type="password" placeholder="Laisser vide = inchangé"
                               class="w-full px-4 py-2.5 rounded-xl text-sm text-white placeholder-slate-600 outline-none transition-all"
                               style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                    </div>
                    <div>
                        <label class="text-xs text-slate-400 mb-1 block">Confirmation</label>
                        <input name="password_confirmation" type="password" placeholder="••••••••"
                               class="w-full px-4 py-2.5 rounded-xl text-sm text-white placeholder-slate-600 outline-none transition-all"
                               style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-teal w-full py-3 rounded-xl text-sm font-semibold text-white">
                Sauvegarder les modifications
            </button>
        </form>
    </div>
</div>
@endsection