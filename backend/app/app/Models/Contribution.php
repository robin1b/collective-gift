<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contribution extends Model
{
    // 1) Zorg dat mass‐assignment werkt
    protected $fillable = [
        'event_id',
        'user_id',      // voor later
        'amount',
        'anonymous',    // fix
    ];

    // 2) Relatie terug naar Event
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
