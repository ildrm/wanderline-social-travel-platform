# ADR-0004: Domain-owned provider ports and deterministic development adapters

- **Status:** Accepted
- **Date:** 2026-09-14
- **Deciders:** Integration architecture

## Context

Maps, routing, weather, translation, notifications, identity, payments, marketplace services, storage and AI depend on external systems whose credentials and regional availability vary. Direct SDK coupling would leak vendor concepts into domain state and make failures difficult to test.

## Decision

Each owning domain defines a small provider port using domain-neutral requests, results, idempotency metadata and a normalized failure taxonomy (`Unavailable`, `Timeout`, `Rejected`, `RateLimited`, `InvalidResponse`, `AuthenticationFailed`). Concrete SDK code, credentials, retry semantics and payload mapping live in infrastructure adapters.

Unavailable integrations receive deterministic development adapters that simulate supported success, rejection, timeout, retry, duplicate callback and out-of-order behavior. Payment, identity and safety-critical fake adapters are rejected during production startup validation and again at execution. Inbound callbacks verify raw-body signatures, timestamp/freshness and unique delivery IDs before a transactional state transition; outgoing webhooks are signed and retryable.

## Consequences

- Providers can be changed and failures tested without changing domain rules.
- The normalized contract may expose fewer vendor-specific features; provider metadata is isolated and versioned.
- Contract suites are required for each adapter, including degraded behavior and replay safety.
- A provider outage cannot convert an unknown operation into success or make unrelated journey data unavailable.

## Alternatives considered

- Direct SDK calls in controllers/models: rejected for coupling, testability and hidden side effects.
- One universal integration interface: rejected because capability and security semantics differ.
- Development credentials in source: rejected; secret references and explicit environment configuration are required.
