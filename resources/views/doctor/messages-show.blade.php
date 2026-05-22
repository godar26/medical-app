@extends('layouts.app')
@section('title', 'Conversation')
@section('page-title', 'Conversation')

@section('content')
<div class="max-w-3xl mx-auto space-y-4">

    {{-- Header --}}
    <div class="card rounded-2xl p-4 flex items-center gap-4 fade-up">
        <a href="{{ auth()->user()->isDoctor() ? route('doctor.messages') : route('patient.messages') }}"
           class="text-slate-400 hover:text-white transition-all">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
        </a>
        <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
            @if($user->avatar)
                <img src="{{ asset('storage/'.$user->avatar) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full teal-gradient flex items-center justify-center text-white font-bold text-sm">
                    {{ strtoupper(substr($user->first_name,0,1)) }}
                </div>
            @endif
        </div>
        <div>
            <p class="text-white font-medium text-sm">
                {{ $user->isDoctor() ? 'Dr. ' : '' }}{{ $user->first_name }} {{ $user->last_name }}
            </p>
            <p class="text-xs" style="color:#2dd4bf">
                {{ $user->isDoctor() ? $user->specialization : 'Patient' }}
            </p>
        </div>
    </div>

    {{-- Messages --}}
    <div class="card rounded-2xl p-6 space-y-4 fade-up-2" style="min-height:400px">
        @forelse($messages as $msg)
            @php $isMe = $msg->sender_id === auth()->id(); @endphp
            <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs lg:max-w-md">
                    @if($isMe)
                        <div class="px-4 py-3 rounded-2xl rounded-br-sm text-sm text-white"
                            style="background:linear-gradient(135deg,#0d9488,#0891b2)">
                            {{ $msg->body }}
                        </div>
                    @else
                        <div class="px-4 py-3 rounded-2xl rounded-bl-sm text-sm"
                            style="background:rgba(255,255,255,0.07);color:#e2e8f0;border:1px solid rgba(255,255,255,0.1)">
                            {{ $msg->body }}
                        </div>
                    @endif
                    <p class="text-xs text-slate-500 mt-1 {{ $isMe ? 'text-right' : 'text-left' }}">
                        {{ $msg->created_at->format('d/m H:i') }}
                    </p>
                </div>
            </div>
        @empty
            <div class="text-center text-slate-500 py-12">
                <svg class="mx-auto mb-2 opacity-30" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
                <p class="text-sm">Démarrez la conversation</p>
            </div>
        @endforelse
    </div>

    {{-- Formulaire --}}
    <div class="card rounded-2xl p-4 fade-up-3">
        <form method="POST"
              action="{{ auth()->user()->isDoctor() ? route('doctor.messages.send',$user) : route('patient.messages.send',$user) }}"
              class="flex gap-3">
            @csrf
            <input type="text" name="body" placeholder="Écrire un message..." required
                   class="flex-1 px-4 py-3 rounded-xl text-sm text-white placeholder-slate-500 outline-none transition-all"
                   style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
            <button type="submit" class="btn-teal px-5 py-3 rounded-xl text-white flex-shrink-0">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="22" y1="2" x2="11" y2="13"/>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
            </button>
        </form>
    </div>
</div>
@endsection