<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\Event;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Haal alle chat-berichten voor dit event.
     */
    public function index(string $join_code)
    {
        $event = Event::where('join_code', $join_code)->firstOrFail();

        return $event
            ->chatMessages()
            ->with('user:id,name')
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Sla een nieuw chat-bericht op en broadcast het.
     */
    public function store(Request $request, string $join_code)
    {
        $data = $request->validate([
            'message' => 'required|string',
        ]);

        $event = Event::where('join_code', $join_code)->firstOrFail();

        $msg = $event->chatMessages()->create([
            'user_id' => $request->user()?->id,  // let op: geen () na ->id
            'message' => $data['message'],
        ]);

        // broadcast naar anderen in dit kanaal
        broadcast(new NewChatMessage($msg))->toOthers();

        return response()->json($msg, 201);
    }
}
