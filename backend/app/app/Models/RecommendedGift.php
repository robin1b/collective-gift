<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendedGift extends Model
{
    protected $fillable = [
        'gift_idea_id',
        'affiliate_url',
        'image_url',
    ];

    // Relatie naar het bijbehorende GiftIdea
    public function giftIdea()
    {
        return $this->belongsTo(GiftIdea::class);
    }
}
