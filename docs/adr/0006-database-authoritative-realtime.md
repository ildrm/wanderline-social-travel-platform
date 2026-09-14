# ADR-0006: Database-authoritative realtime with Laravel Reverb-compatible transport

- **Status:** Accepted
- **Date:** 2026-09-14
- **Deciders:** Realtime and platform architecture

## Context

Chat, announcements, acknowledgments, application status and live-trip updates benefit from low-latency delivery. They also require durable history, authorization, replay after reconnect and safe behavior when websocket infrastructure fails.

## Decision

Use Laravel Reverb or an equivalent production-compatible WebSocket adapter behind application-owned realtime interfaces. Persist every durable message/state transition in PostgreSQL first, record an outbox event in the same transaction, and broadcast asynchronously after commit. Redis supports transient presence, fanout coordination and rate limiting in separate namespaces; it is not the durable source of truth.

Authenticate each subscription and command server-side against current contextual policies. Channel names and client-supplied membership are never authority. Reconnect uses cursor/sequence-based HTTP synchronization; critical announcements remain available through the ordinary API and may require persisted acknowledgment.

## Consequences

- Websocket outage degrades to polling/reconnect without losing committed state.
- Delivery is at least once; clients and consumers deduplicate event IDs and tolerate reordering.
- Presence may be approximate and must not imply safety or expose precise location.
- Horizontal scaling requires shared Redis coordination and connection metrics, not sticky domain state.

## Alternatives considered

- Websocket-only durable state: rejected due to loss, replay and consistency risks.
- Polling only: retained as fallback but rejected as the primary collaboration experience.
- Managed-vendor concepts in domain code: rejected; a transport adapter preserves portability.
