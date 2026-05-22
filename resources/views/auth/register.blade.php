@extends('layouts.app')
@section('title', 'Inscription')

@push('styles')
<style>
    input[type="radio"]:checked + .role-box {
        border-color: #0d9488 !important;
        background: rgba(13,148,136,0.15) !important;
        color: #2dd4bf;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center p-4"
     style="background: radial-gradient(ellipse at 20% 50%, rgba(13,148,136,0.15) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 20%, rgba(8,145,178,0.1) 0%, transparent 50%),
                        #0f172a">
    <div class="w-full max-w-lg fade-up">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-3 mb-3">
                <div class="w-12 h-12 rounded-2xl teal-gradient flex items-center justify-center">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                </div>
                <span class="font-display text-3xl font-semibold text-white">
                    Medi<span style="color:#2dd4bf">Book</span>
                </span>
            </div>
            <p class="text-slate-400 text-sm">Créez votre compte professionnel</p>
        </div>

        <div class="card rounded-2xl p-8">

            {{-- Erreurs --}}
            @if($errors->any())
                <div class="mb-5 px-4 py-3 rounded-xl text-sm"
                     style="background:#4c051922;color:#f87171;border:1px solid #7f1d1d55">
                    @foreach($errors->all() as $e)
                        <p>• {{ $e }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}"
                  enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Sélecteur de rôle --}}
                <div>
                    <p class="text-xs text-slate-400 mb-2">Je suis...</p>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="patient" class="sr-only"
                                {{ old('role', 'patient') === 'patient' ? 'checked' : '' }}>
                            <div class="role-box p-4 rounded-xl border text-center transition-all select-none"
                                 style="border-color:rgba(255,255,255,0.1);background:rgba(255,255,255,0.03)">
                                <svg class="mx-auto mb-2 text-slate-300" width="24" height="24" fill="none"
                                     stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                <p class="text-sm font-medium">Patient</p>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="role" value="doctor" class="sr-only"
                                {{ old('role') === 'doctor' ? 'checked' : '' }}>
                            <div class="role-box p-4 rounded-xl border text-center transition-all select-none"
                                 style="border-color:rgba(255,255,255,0.1);background:rgba(255,255,255,0.03)">
                                <svg class="mx-auto mb-2 text-slate-300" width="24" height="24" fill="none"
                                     stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M12 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                                    <path d="M9 11H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-8a1 1 0 0 0-1-1h-5"/>
                                    <path d="M12 11v10M9 14h6"/>
                                </svg>
                                <p class="text-sm font-medium">Médecin</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Prénom / Nom --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs text-slate-400 mb-1 block">Prénom</label>
                        <input name="first_name" value="{{ old('first_name') }}" type="text"
                               placeholder="Mohamed" required
                               class="w-full px-4 py-2.5 rounded-xl text-sm text-white placeholder-slate-500 transition-all"
                               style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                    </div>
                    <div>
                        <label class="text-xs text-slate-400 mb-1 block">Nom</label>
                        <input name="last_name" value="{{ old('last_name') }}" type="text"
                               placeholder="Alami" required
                               class="w-full px-4 py-2.5 rounded-xl text-sm text-white placeholder-slate-500 transition-all"
                               style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="text-xs text-slate-400 mb-1 block">Email</label>
                    <input name="email" value="{{ old('email') }}" type="email"
                           placeholder="email@exemple.com" required
                           class="w-full px-4 py-2.5 rounded-xl text-sm text-white placeholder-slate-500 transition-all"
                           style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                </div>

                {{-- Mot de passe --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs text-slate-400 mb-1 block">Mot de passe</label>
                        <input name="password" type="password" placeholder="••••••••" required
                               class="w-full px-4 py-2.5 rounded-xl text-sm text-white placeholder-slate-500 transition-all"
                               style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                    </div>
                    <div>
                        <label class="text-xs text-slate-400 mb-1 block">Confirmation</label>
                        <input name="password_confirmation" type="password" placeholder="••••••••" required
                               class="w-full px-4 py-2.5 rounded-xl text-sm text-white placeholder-slate-500 transition-all"
                               style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                    </div>
                </div>

                {{-- Champs Médecin --}}
                <div id="doctor-fields" class="{{ old('role') === 'doctor' ? '' : 'hidden' }} space-y-4">
                    <div style="border-top:1px solid rgba(255,255,255,0.07)" class="pt-4">
                        <p class="text-xs mb-3 font-medium uppercase tracking-wider" style="color:#2dd4bf">
                            Informations médicales
                        </p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-400 mb-1 block">Spécialisation</label>
                        <input name="specialization" value="{{ old('specialization') }}" type="text"
                               placeholder="Cardiologie, Pédiatrie..."
                               class="w-full px-4 py-2.5 rounded-xl text-sm text-white placeholder-slate-500 transition-all"
                               style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                    </div>
                    <div>
                        <label class="text-xs text-slate-400 mb-1 block">Frais de consultation (MAD)</label>
                        <input name="consultation_fee" value="{{ old('consultation_fee') }}" type="number"
                               placeholder="300" min="0"
                               class="w-full px-4 py-2.5 rounded-xl text-sm text-white placeholder-slate-500 transition-all"
                               style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                    </div>
                    <div>
                        <label class="text-xs text-slate-400 mb-1 block">Biographie</label>
                        <textarea name="biography" rows="3"
                                  placeholder="Décrivez votre parcours et expérience..."
                                  class="w-full px-4 py-2.5 rounded-xl text-sm text-white placeholder-slate-500 transition-all resize-none"
                                  style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">{{ old('biography') }}</textarea>
                    </div>
                </div>

                {{-- Avatar --}}
                <div>
                    <label class="text-xs text-slate-400 mb-1 block">Photo de profil (optionnel)</label>
        <input name="avatar" type="file" accept=".jpg,.jpeg,.png"
       id="avatar-input"
       class="w-full px-4 py-2.5 rounded-xl text-sm text-slate-400 transition-all cursor-pointer
              file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0
              file:text-xs file:font-medium file:cursor-pointer file:text-white file:bg-teal-600"
       style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">

                <button type="submit" class="btn-teal w-full py-3 rounded-xl text-sm font-semibold text-white">
                    Créer mon compte →
                </button>
            </form>

            <p class="text-center text-sm text-slate-400 mt-5">
                Déjà un compte ?
                <a href="{{ route('login') }}" style="color:#2dd4bf" class="font-medium hover:underline">
                    Se connecter
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const radios = document.querySelectorAll('input[name="role"]');
    const doctorFields = document.getElementById('doctor-fields');

    function toggleDoctor() {
        const isDoctor = document.querySelector('input[name="role"]:checked')?.value === 'doctor';
        doctorFields.classList.toggle('hidden', !isDoctor);
        doctorFields.querySelectorAll('input, textarea').forEach(el => {
            el.required = isDoctor;
        });
    }

    radios.forEach(r => r.addEventListener('change', toggleDoctor));
    toggleDoctor();
</script>
@endpush