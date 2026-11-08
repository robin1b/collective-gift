# Collective Gift

Platform om samen een cadeau te regelen: een organisator maakt een event aan, deelt een code en gasten dragen bij, stellen cadeau-ideeën voor, stemmen en chatten. Dit is de volledige repo van mijn eindwerk (juni 2025). De Laravel-API in `backend/app` is uitgewerkt; de map `frontend/` bevat enkel de Next.js-basisopzet.

*English: Group-gift platform (final project, June 2025) with a Laravel API for events, contributions, gift-idea voting and chat; the Next.js frontend folder is only scaffolded.*

## Wat erin zit
- Events met deadline, doelbedrag en publiek/privé; elk event krijgt een unieke `join_code` voor gasten en een `admin_code` voor de beheerder
- Gasten (zonder account) bekijken een event, dragen bij en stellen cadeau-ideeën voor via de `join_code`
- Anoniem stemmen op cadeau-ideeën, met stemtelling per idee
- Chat per event, realtime uitgezonden via Laravel broadcasting (Pusher)
- Bijdragen via een Stripe PaymentIntent; een webhook-handler en Stripe Connect-flow staan in `StripeController`, maar zijn nog niet aan routes gekoppeld
- Registreren, inloggen en API-tokens met Laravel Sanctum; Google-login via Socialite is voorbereid
- Superadmin-rol met CRUD voor aanbevolen cadeaus (API en Blade-beheerpagina's), afgeschermd met policies

## Techniek
Laravel 12 (PHP 8.2+), Sanctum, Socialite, Stripe PHP SDK, Pusher, Breeze, Tailwind · frontend: Next.js 15, React 19, TypeScript, Tailwind 4.

## Lokaal draaien
Backend:
```bash
cd backend/app
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```
Vul in `.env` daarnaast `STRIPE_SECRET_KEY`, `STRIPE_WEBHOOK_SECRET`, de Pusher-gegevens (`BROADCAST_CONNECTION=pusher`, `PUSHER_APP_ID`, `PUSHER_APP_KEY`, `PUSHER_APP_SECRET`, `PUSHER_APP_CLUSTER`) en eventueel `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URL` in. Met Lando kan het ook: `lando start` in `backend/`.

Frontend:
```bash
cd frontend
npm install
npm run dev
```

## Status
Eindwerk, juni 2025. Afgewerkt, niet meer in ontwikkeling.

---
_Nagekeken in november 2026 door Robin, met hulp van een AI-agent._
