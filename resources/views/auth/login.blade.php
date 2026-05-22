@extends('layouts.app')
@section('title', 'Connexion')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4" style="background: radial-gradient(ellipse at 20% 50%, rgba(13,148,136,0.15) 0%, transparent 60%), radial-gradient(ellipse at 80% 20%, rgba(8,145,178,0.1) 0%, transparent 50%), #0f172a">
    <div class="w-full max-w-md fade-up">
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-2xl teal-gradient flex items-center justify-center">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                </div>
                <span class="font-display text-3xl font-700 text-white">Medi<span style="color:#2dd4bf">Book</span></span>
            </div>
            <p class="text-slate-400 text-sm">Bon retour parmi nous</p>
        </div>

        <div class="card rounded-2xl p-8">
            @if($errors->any())
                <div class="mb-5 px-4 py-3 rounded-xl text-sm" style="background:#4c051933;color:#f87171;border:1px solid #7f1d1d55">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-xs text-slate-400 mb-1 block">Adresse email</label>
                    <input name="email" type="email" value="{{ old('email') }}" placeholder="email@exemple.com" required autofocus
                        class="w-full px-4 py-3 rounded-xl text-sm text-white placeholder-slate-500 outline-none transition-all"
                        style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                </div>
                <div>
                    <label class="text-xs text-slate-400 mb-1 block">Mot de passe</label>
                    <input name="password" type="password" placeholder="••••••••" required
                        class="w-full px-4 py-3 rounded-xl text-sm text-white placeholder-slate-500 outline-none transition-all"
                        style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="rounded accent-teal-500">
                    <label for="remember" class="text-sm text-slate-400">Se souvenir de moi</label>
                </div>
                <button type="submit" class="btn-teal w-full py-3 rounded-xl text-sm font-600 text-white">
                    Se connecter →
                </button>
            </form>

            <p class="text-center text-sm text-slate-400 mt-5">
                Pas encore de compte ?
                <a href="{{ route('register') }}" style="color:#2dd4bf" class="font-500 hover:underline">S'inscrire</a>
            </p>
        </div>
    </div>
</div>
@push('styles')
<style>
    input:focus {
        border-color: #0d9488 !important;
        box-shadow: 0 0 0 3px rgba(13,148,136,0.2) !important;
    }
</style>
@endpush
@endsection