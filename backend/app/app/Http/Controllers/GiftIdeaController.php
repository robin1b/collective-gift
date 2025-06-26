<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\GiftIdea;
use Illuminate\Http\Request;

class GiftIdeaController extends Controller
{
    // GET /api/events/join/{join_code}/gift_ideas
    public function indexGuest(string $join_code)
    {
        $event = Event::where('join_code', $join_code)
            ->with('giftIdeas')
            ->firstOrFail();

        return response()->json(
            $event->giftIdeas->map(fn($gi) => [
                'id'          => $gi->id,
                'title'       => $gi->title,
                'description' => $gi->description,
            ])
        );
    }

    // POST /api/events/join/{join_code}/gift_ideas
    public function storeGuest(Request $request, string $join_code)
    {
        $event = Event::where('join_code', $join_code)->firstOrFail();

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $gi = $event->giftIdeas()->create($data);

        return response()->json($gi, 201);
    }
}
