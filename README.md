# Wanderline

Wanderline is a privacy-first global social travel platform built as a modular monorepo. The repository currently contains the verified platform spine, secure browser sessions, owner-scoped Journey lifecycle APIs, a responsive Explore experience, public journey pages, and Quick Create.

This is an active implementation of `PROMPT-SOL-HIGH.md`, not a claim that all 250 product requirements are complete. Current status and next work are recorded in `docs/execution-state.md`; the requirement ledger is `docs/requirements-traceability.md`.

## Stack

- Laravel 13 / PHP 8.5 API
- Next.js 16 / React 19 / TypeScript web application
- PostgreSQL 18 + PostGIS
- Redis with separated cache, queue, rate-limit, presence, and realtime concerns
- S3-compatible private object storage through MinIO in development
- Docker Compose locally; hardened runtime images and Kubernetes deployment examples

## Start locally

Prerequisites: Docker Engine with Compose v2, OpenSSL, and Make.

```sh
make bootstrap
make up
```

Then open:

- Web: http://localhost:3000
- API health: http://localhost:8080/api/v1/health
- Mailpit: http://127.0.0.1:8025
- MinIO console: http://127.0.0.1:9001

`make bootstrap` creates a protected, ignored `.env`, builds the images, and does not commit credentials. `make clean` stops containers while retaining local volumes.

## Verify without the full stack

```sh
npm install
npm run lint:web
npm run typecheck:web
npm run test:web
npm run build:web

cd apps/api
composer install
composer lint
composer analyse
composer test -- --compact
```

Container and configuration checks:

```sh
make compose-config
make build
kubectl kustomize infrastructure/deployment/kubernetes
```

## Implemented API surface

- `GET /api/v1/health`
- `GET /api/v1/readiness`
- `POST /api/v1/auth/register`
- `POST /api/v1/auth/login`
- `GET /api/v1/auth/user`
- `POST /api/v1/auth/logout`
- `GET /api/v1/journeys`
- `POST /api/v1/journeys`
- `GET /api/v1/journeys/{journey}`
- `GET /api/v1/journeys/{journey}/itinerary`
- `POST /api/v1/journeys/{journey}/itinerary`
- `POST /api/v1/journeys/{journey}/transitions`

Browser authentication uses first-party HttpOnly session cookies with Sanctum/CSRF protection. Journey access is owner-scoped; lifecycle transitions are authorized, row-locked, and history-backed. Itinerary creation persists normalized days, stops, locations, transportation legs, and activities transactionally while keeping exact coordinates out of responses.

## Repository map

- `apps/api` — Laravel API, domain services, policies, migrations, and tests
- `apps/web` — Next.js UI, localized copy, component tests, and production assets
- `docs` — domain/security/permission architecture, ADRs, traceability, visual evidence, and execution state
- `infrastructure` — Docker, health checks, monitoring, deployment examples, and environment bootstrap
- `.github` — CI, dependency updates, and pull-request checks

The design concept, verified desktop/mobile renders, and fidelity decisions are under `docs/design`.
