<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ChatMessage $message;

    /**
     * Create a new event instance.
     */
    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
    }

    /**
     * The channel the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        // private channel per event, bijv. 'chat.5'
        return new PrivateChannel('chat.' . $this->message->event_id);
    }

    /**
     * Data die naar de clients gebroadcast wordt.
     */
    public function broadcastWith(): array
    {
        return [
            'id'         => $this->message->id,
            'user_id'    => $this->message->user_id,
            'username'   => $this->message->user->name,
            'message'    => $this->message->message,
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }
}
