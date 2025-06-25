<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;

class EventController extends Controller
{
    use AuthorizesRequests;

    /**
     * GET /api/events
     */
    public function index(): JsonResponse
    {
        $events = Event::where('organizer_id', Auth::id())
            ->orWhere('privacy', 'public')
            ->get();

        return response()->json($events);
    }

    /**
     * POST /api/events
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'admin_name'  => 'required|string|max:255',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline'    => 'required|date',
            'privacy'     => 'required|in:public,private',
            'goal_amount' => 'nullable|numeric|min:0',
        ]);

        $data['organizer_id'] = 1; // placeholder
        $data['admin_code']   = Str::random(16);
        $data['join_code']    = Str::upper(Str::random(8));

        $event = Event::create($data);

        return response()->json([
            'id'          => $event->id,
            'admin_code'  => $event->admin_code,
            'join_code'   => $event->join_code,
        ], 201);
    }
    /**
     * GET /api/events/{event}
     */
    public function show(Event $event): JsonResponse
    {
        if ($event->privacy === 'private' && $event->organizer_id !== Auth::id()) {
            abort(403);
        }
        return response()->json($event);
    }

    /**
     * PUT /api/events/{event}
     */
    public function update(Request $r, Event $event): JsonResponse
    {
        // controleer of je dit mag
        $this->authorize('update', $event);

        // 1) valideer input
        $data = $r->validate([
            'name'                        => 'sometimes|required|string|max:255',
            'description'                 => 'nullable|string',
            'deadline'                    => 'sometimes|required|date',
            'privacy'                     => 'sometimes|required|in:public,private',
            'password_protected'          => 'boolean',
            'password'                    => 'nullable|string|min:4',
            'anonymous_contributions'     => 'boolean',
            'show_contribution_breakdown' => 'boolean',
        ]);

        // 2) pas password-hash toe indien nodig
        if (! empty($data['password_protected']) && ! empty($data['password'])) {
            $data['password_hash'] = bcrypt($data['password']);
        }

        // 3) update en return
        $event->update($data);
        return response()->json($event);
    }

    /**
     * DELETE /api/events/{event}
     */
    public function destroy(Event $event): Response
    {
        $this->authorize('delete', $event);
        $event->delete();
        return response()->noContent();
    }
}
