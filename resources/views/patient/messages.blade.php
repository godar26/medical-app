@extends('layouts.app')
@section('title', 'Messages')
@section('page-title', 'Messages')

@section('content')
<div class="space-y-3 fade-up">
    @forelse($conversations as $userId => $lastMsg)
        @php
            $other = $lastMsg->sender_id === auth()->id() ? $lastMsg->receiver : $lastMsg->sender;
            $unread = \App\Models\Message::where('sender_id',$other->id)
                        ->where('receiver_id',auth()->id())
                        ->where('is_read',false)->count();
        @endphp
        <a href="{{ route('patient.messages.show', $other) }}"
           class="card rounded-2xl p-4 flex items-center gap-4 hover:border-teal-800 transition-all block">
            <div class="w-11 h-11 rounded-full overflow-hidden flex-shrink-0" style="border:2px solid rgba(255,255,255,0.1)">
                @if($other->avatar)
                    <img src="{{ asset('storage/'.$other->avatar) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full teal-gradient flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($other->first_name,0,1)) }}
                    </div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <p class="text-white font-medium text-sm">Dr. {{ $other->first_name }} {{ $other->last_name }}</p>
                    <p class="text-xs text-slate-500">{{ $lastMsg->created_at->diffForHumans() }}</p>
                </div>
                <p class="text-slate-400 text-xs truncate mt-0.5">{{ $lastMsg->body }}</p>
            </div>
            @if($unread > 0)
                <span class="w-5 h-5 rounded-full text-xs flex items-center justify-center font-bold text-white flex-shrink-0"
                      style="background:#0d9488">{{ $unread }}</span>
            @endif
        </a>
    @empty
        <div class="card rounded-2xl p-12 text-center">
            <svg class="mx-auto mb-3 opacity-20" width="48" height="48" fill="none" stroke="white" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            <p class="text-slate-400">Aucune conversation</p>
            <a href="{{ route('patient.doctors') }}" class="text-xs mt-1 inline-block" style="color:#2dd4bf">
                Contacter un médecin →
            </a>
        </div>
    @endforelse
</div>
@endsection