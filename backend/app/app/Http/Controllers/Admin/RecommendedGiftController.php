<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;             // ← juiste basiscontroller import
use App\Models\RecommendedGift;
use App\Models\GiftIdea;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RecommendedGiftController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // zorg dat alle routes in deze controller authenticatie + autorisatie gebruiken
        $this->middleware('auth');
        // automatisch policies toepassen op resource-methodes
        $this->authorizeResource(RecommendedGift::class, 'recommended_gift');
    }

    /**
     * GET /admin/recommended-gifts
     */
    public function index()
    {
        $gifts = RecommendedGift::with('giftIdea')->paginate(20);
        return view('admin.recommended_gifts.index', compact('gifts'));
    }

    /**
     * GET /admin/recommended-gifts/create
     */
    public function create()
    {
        $ideas = GiftIdea::all();
        return view('admin.recommended_gifts.create', compact('ideas'));
    }

    /**
     * POST /admin/recommended-gifts
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'gift_idea_id'  => 'required|exists:gift_ideas,id',
            'affiliate_url' => 'required|url|max:255',
        ]);

        RecommendedGift::create($data);

        return redirect()
            ->route('admin.gifts.index')
            ->with('success', 'Aanbevolen cadeau toegevoegd.');
    }

    /**
     * GET /admin/recommended-gifts/{recommended_gift}/edit
     */
    public function edit(RecommendedGift $recommended_gift)
    {
        $ideas = GiftIdea::all();
        return view('admin.recommended_gifts.edit', compact('recommended_gift', 'ideas'));
    }

    /**
     * PUT /admin/recommended-gifts/{recommended_gift}
     */
    public function update(Request $request, RecommendedGift $recommended_gift)
    {
        $data = $request->validate([
            'gift_idea_id'  => 'required|exists:gift_ideas,id',
            'affiliate_url' => 'required|url|max:255',
        ]);

        $recommended_gift->update($data);

        return redirect()
            ->route('admin.gifts.index')
            ->with('success', 'Aanbevolen cadeau bijgewerkt.');
    }

    /**
     * DELETE /admin/recommended-gifts/{recommended_gift}
     */
    public function destroy(RecommendedGift $recommended_gift)
    {
        $recommended_gift->delete();

        return redirect()
            ->route('admin.gifts.index')
            ->with('success', 'Aanbevolen cadeau verwijderd.');
    }
}
