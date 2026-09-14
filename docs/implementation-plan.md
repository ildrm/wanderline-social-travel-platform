# Implementation plan

**Status:** Approved execution sequence  
**Updated:** 2026-09-14

## Delivery contract

Build thin, production-quality vertical slices in dependency order. A slice includes schema constraints, domain rules, application service, provider boundary where relevant, versioned API, authorization, UI states, localization, accessibility, telemetry, fixtures, and automated tests. Broad disconnected scaffolding does not advance a requirement beyond `FOUNDATION_ONLY`.

Verified stack baseline:

- Laravel 13 and PHP 8.5 backend
- Next.js current stable, with the exact version locked by the repository foundation workflow
- PostgreSQL 18 with PostGIS
- Redis for distinct cache, queue, throttle, presence and realtime concerns
- S3-compatible object storage with a local-development adapter

## Cross-cutting implementation rules

1. Use a modular monolith and versioned REST API/OpenAPI; generated contracts connect backend and strict TypeScript.
2. Use PostgreSQL transactions and a transactional outbox for durable state plus asynchronous effects.
3. Apply deny-by-default contextual policies in the backend. C3 data uses separated encrypted storage and audited, purpose-bound access.
4. Implement provider ports, normalized failures and deterministic development adapters; reject payment/identity/safety fakes in production.
5. Keep public/search projections privacy-filtered at creation. Redis/search/realtime/analytics are non-authoritative.
6. Start each behavior with acceptance and threat/privacy criteria; finish only after narrow checks pass and traceability contains evidence.

## Milestones and exit gates

| Milestone | Vertical outcomes | Required exit evidence |
|---|---|---|
| M0 Repository foundation | Monorepo, Docker services, configuration validation, API/error/idempotency/event conventions, health endpoints, CI, logging/metrics skeleton, design tokens and localized app shell | Clean install/build; PostgreSQL/PostGIS, Redis and storage readiness; format/static/type/unit/smoke checks; no committed secrets; production fake-provider guard test |
| M1 Identity and privacy foundation | Registration/login/recovery, secure sessions, email/phone development verification, passkey/MFA-ready interfaces, profile separation, field visibility, organization membership, contextual policy kernel, consent/retention/audit foundations | Session rotation/CSRF/rate-limit/ATO tests; horizontal/vertical authorization tests; C3 repository separation; admin reauth negative tests |
| M2 Journey Graph core | Journey modes/types, lifecycle and history, days/stops/legs, PostGIS locations/precision, activities/demand/capacity, eligibility, meals/equipment/accommodation, versioning, completeness and simulator | Domain/state/chronology/timezone/geo/privacy tests; migration constraints/index review; reference Ankara round-trip fixture renders via API |
| M3 Creation, discovery and participation | Quick Create, guided responsive builder, autosave/recovery, privacy preview, public journey SSR page, text/map search, saved searches, applications/questions, atomic acceptance/waitlist, notifications | AC-A core and AC-C E2E; public payload excludes private fields; last-seat application concurrency; keyboard builder/map-list alternative; SEO privacy checks |
| M4 Collaboration and live safety | Scoped messaging/files, announcements/acknowledgments/translation, governance/change proposals/impact, readiness/check-in, Live Trip, safety center, trusted contact/check-ins/SOS, incident access, offline pack | AC-B, AC-F location/health/message subset, AC-G; websocket authorization; malicious upload; offline encryption/expiry; provider outage keeps itinerary readable |
| M5 Commercial and marketplace | Money types, pricing/cancellation versions, payment intents/webhooks, balanced immutable ledger, refunds/disputes/payout/reconciliation, journey-attached bookings and failure states | AC-D, AC-E and AC-H; signature/replay/out-of-order/idempotency tests; balanced-ledger constraints; production fake-payment rejection; no false optimistic success |
| M6 Trust, communities and completion | Communities/meetups including romantic safeguards, blocks/reports/moderation/appeals, reviews/reputation, support/admin scoped views, memories/media/lost-and-found/repeat journeys | Adult/minor and block graph negative tests; verified/double-blind reviews; moderator/admin access audit; post-trip privacy and deletion propagation tests |
| M7 AI, advanced providers and intelligence | AI gateway, reviewable tour extraction, organizer/participant assistants, qualified high-risk approval, intent search/recommendations, calendar, regional policies, professional analytics and remaining marketplace adapters | Prompt-injection/redaction/authorization/tool tests; human-confirmation/qualification tests; provider contract suites; no C3 analytics/AI leakage; non-AI workflows remain complete |
| M8 Production hardening and delivery | PWA/offline resilience, observability/SLOs, restore/DR exercise, load/race/failure tests, supply-chain controls, five evidence-backed review cycles, synchronized OpenAPI/ERD/operator/user docs | Full CI/E2E/security/accessibility regression; performance report; successful restore evidence; SBOM/scans; all §1–§250 and AC-A–AC-H rows split and truthfully verified or explicitly external-blocked |

## First executable slices

### Slice 0.1: runnable platform spine

Create the locked Laravel/Next.js workspaces, local PostgreSQL/PostGIS/Redis/S3-compatible services, a correlation-aware `/api/v1/health` contract, localized accessible web shell, and CI gates. Do not introduce user/domain tables beyond infrastructure needs.

### Slice 1.1: secure account session

Implement registration, email-verification development adapter, login/logout, session listing/revocation, password recovery, throttles, CSRF and audit events. Browser authentication uses first-party HttpOnly cookie sessions; non-browser token needs are modeled separately.

### Slice 1.2: profile visibility and organization boundary

Create separate public/private profiles, visibility policy evaluation, organization membership and journey-context role primitives. Prove unauthorized cross-user and cross-tenant reads fail before Journey features depend on them.

### Slice 2.1: minimum complete Journey Graph path

Implement a draft social journey with two stops, one leg, one activity, lifecycle transition, approximate/exact location split and a day-by-day query. Add more entity variants only after this path is runnable and tested.

## Verification ladder

For each slice, run the narrowest formatter, static analysis, domain/unit tests, database/integration/API tests, authorization/security tests, frontend component/integration tests, and targeted E2E. At milestone boundaries run the complete backend, frontend, contract, migration, E2E, accessibility, dependency and container smoke suites.

Review evidence records inspected files, findings, fixes, commands and results. Manual accessibility, UX, domain operations and restore exercises name the scenario and reviewer lens; automated tooling alone cannot satisfy those gates.

## Sequencing and rollback

- Database changes use expand/migrate/contract where deployed data may exist. Index and constraint operations consider locks and table size.
- Features that change legal exposure, payments, romantic discovery, AI or regions remain server-side flagged; flags never replace authorization.
- Provider launches use development contract tests, sandbox verification when credentials exist, then controlled enablement. Failure rolls back the adapter/flag, not committed domain truth.
- Deployments are backward compatible across web/API/worker versions. Jobs and events are versioned and retry safe.
- No PostgreSQL sharding, Kafka, Kubernetes, service mesh, global CQRS or event sourcing is introduced without measured evidence and an ADR.

## Completion accounting

`docs/requirements-traceability.md` is the release ledger. Overall completion requires implementation and test evidence for all 250 sections and AC-A through AC-H, plus synchronized execution state. Missing credentials may block external verification but never justify removing the contract, security validation, deterministic failure modes or tests.
