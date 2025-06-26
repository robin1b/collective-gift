<?php

namespace App\Policies;

namespace App\Policies;

use App\Models\RecommendedGift;
use App\Models\User;

class RecommendedGiftPolicy
{
    public function before(User $user, $ability)
    {
        // Enkel users met role='superadmin' mogen alles
        if ($user->role === 'superadmin') {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return false;
    }
    public function view(User $user, RecommendedGift $gift): bool
    {
        return false;
    }
    public function create(User $user): bool
    {
        return false;
    }
    public function update(User $user, RecommendedGift $gift): bool
    {
        return false;
    }
    public function delete(User $user, RecommendedGift $gift): bool
    {
        return false;
    }
}
