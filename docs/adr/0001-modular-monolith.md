# ADR-0001: API-first modular monolith

- **Status:** Accepted
- **Date:** 2026-09-14
- **Deciders:** Platform architecture

## Context

The platform spans many domains but begins as one product and requires strong transactions across capacity, applications, bookings and money. Premature services would add distributed transactions, deployment and observability burden before workload or team boundaries are measured.

## Decision

Use a monorepo containing a Laravel 13/PHP 8.5 modular-monolith API and a separately built Next.js current-stable frontend; the root foundation locks the exact Next.js version. Each backend bounded context exposes application interfaces and events while hiding internal models/repositories. PostgreSQL 18/PostGIS is authoritative; Redis, S3-compatible storage, search projections and realtime are adapters. Versioned REST/OpenAPI is the client boundary.

Use a transactional outbox for committed domain events. Cross-context synchronous calls are limited to invariants requiring an immediate result. No context imports another context's internal implementation.

## Consequences

- Strong local transactions, one operational deployment shape, and straightforward debugging.
- Boundary linting/review and contract tests are required to prevent a coupled monolith.
- Independent deployment is unavailable initially. A module may be extracted only for measured scaling, isolation, availability, technology or ownership reasons and requires a new ADR.

## Alternatives considered

- Microservices: rejected initially due to operational and consistency cost.
- Traditional layered monolith: rejected because it does not preserve explicit business boundaries.
- Event sourcing/CQRS everywhere: rejected as artificial complexity; projections and append-only history are used only where justified.
