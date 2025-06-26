<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftIdea extends Model
{
    protected $fillable = ['event_id', 'title', 'description'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
