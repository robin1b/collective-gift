<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function indexGuest(string $join_code)
    {
        $event = Event::where('join_code', $join_code)
            ->with('giftIdeas.votes')
            ->firstOrFail();

        $payload = $event->giftIdeas->map(fn($gi) => [
            'id'    => $gi->id,
            'title' => $gi->title,
            'votes' => $gi->votes->count(),
        ]);

        return response()->json($payload);
    }

    public function storeGuest(Request $request, string $join_code)
    {
        $event = Event::where('join_code', $join_code)->firstOrFail();

        $data = $request->validate([
            'gift_idea_id' => 'required|exists:gift_ideas,id',
        ]);

        $vote = Vote::create([
            'event_id'     => $event->id,
            'gift_idea_id' => $data['gift_idea_id'],
            'user_id'      => null, // anoniem
        ]);

        return response()->json($vote, 201);
    }
}
