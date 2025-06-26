<?php

namespace App\Providers;

use App\Models\Event;
use App\Policies\EventPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\RecommendedGift;
use App\Policies\RecommendedGiftPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Map models naar policies.
     */
    protected $policies = [
        Event::class => EventPolicy::class,
        RecommendedGift::class => RecommendedGiftPolicy::class,
    ];

    /**
     * Registreer de policies.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
