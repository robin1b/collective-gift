<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['event_id', 'user_id', 'gift_idea_id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function giftIdea()
    {
        return $this->belongsTo(GiftIdea::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
