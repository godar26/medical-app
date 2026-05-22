<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function doctorIndex()
    {
        $conversations = Message::where('receiver_id', Auth::id())
            ->orWhere('sender_id', Auth::id())
            ->with(['sender', 'receiver'])
            ->get()
            ->groupBy(function($msg) {
                $other = $msg->sender_id === Auth::id() ? $msg->receiver_id : $msg->sender_id;
                return $other;
            })
            ->map(function($msgs) {
                return $msgs->sortByDesc('created_at')->first();
            })
            ->filter(function($msg) {
                $otherId = $msg->sender_id === Auth::id() ? $msg->receiver_id : $msg->sender_id;
                $other = User::find($otherId);
                return $other && $other->role === 'patient';
            })
            ->sortByDesc('created_at');

        $unreadCount = Message::where('receiver_id', Auth::id())->where('is_read', false)->count();

        return view('doctor.messages', compact('conversations', 'unreadCount'));
    }

    public function patientIndex()
    {
        $conversations = Message::where('receiver_id', Auth::id())
            ->orWhere('sender_id', Auth::id())
            ->with(['sender', 'receiver'])
            ->get()
            ->groupBy(function($msg) {
                $other = $msg->sender_id === Auth::id() ? $msg->receiver_id : $msg->sender_id;
                return $other;
            })
            ->map(function($msgs) {
                return $msgs->sortByDesc('created_at')->first();
            })
            ->filter(function($msg) {
                $otherId = $msg->sender_id === Auth::id() ? $msg->receiver_id : $msg->sender_id;
                $other = User::find($otherId);
                return $other && $other->role === 'doctor';
            })
            ->sortByDesc('created_at');

        return view('patient.messages', compact('conversations'));
    }

    public function show(User $user)
    {
        // Marquer comme lus
        Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::where(function($q) use ($user) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
            })->orWhere(function($q) use ($user) {
                $q->where('sender_id', $user->id)->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at')
            ->get();

        $role = Auth::user()->role;
        return view("{$role}.messages-show", compact('messages', 'user'));
    }

    public function send(Request $request, User $user)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $user->id,
            'body'        => $request->body,
        ]);

        $role = Auth::user()->role;
        return redirect()->route("{$role}.messages.show", $user->id)
            ->with('success', 'Message envoyé.');
    }
}